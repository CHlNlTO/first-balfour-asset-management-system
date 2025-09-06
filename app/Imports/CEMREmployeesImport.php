<?php
// File: app/Imports/CEMREmployeesImport.php

namespace App\Imports;

use App\Models\CEMRCostCode;
use App\Models\CEMRDivision;
use App\Models\CEMREmployee;
use App\Models\CEMREmpService;
use App\Models\CEMRPosition;
use App\Models\CEMRProject;
use App\Models\CEMRRank;
use App\Models\CEMRStatus;
use Illuminate\Bus\Queueable;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Row;
use Filament\Notifications\Notification;
use Filament\Notifications\DatabaseNotification;

class CEMREmployeesImport implements OnEachRow, WithChunkReading, WithCustomCsvSettings, WithEvents, ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * In-memory caches to reduce query volume during import
     */
    protected array $rankNameToId = [];
    protected array $positionNameToId = [];
    protected array $costCodeNameToId = [];
    protected array $projectNameToId = [];
    protected array $divisionNameToId = [];
    protected array $statusNameToId = [];

    protected bool $headerDetected = false;
    protected bool $associativeRows = false;
    protected array $headerMap = [];

    protected int $companyId = 1; // default to company id 1

    // Summary counters
    protected int $processed = 0;
    protected int $createdEmployees = 0;
    protected int $skippedExisting = 0;
    protected array $lookupsCreated = [
        'ranks' => 0,
        'positions' => 0,
        'cost_codes' => 0,
        'projects' => 0,
        'divisions' => 0,
        'statuses' => 0,
    ];
    protected array $failures = [];

    public function __construct(protected ?int $userId = null, protected ?string $filePath = null)
    {
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ',',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onRow(Row $row): void
    {
        $rowIndex = $row->getIndex();
        $cells = $row->toArray();

        // Restore persisted state for chunked queued imports
        if ($this->filePath) {
            $state = Cache::get($this->cacheKey('state'));
            if (is_array($state)) {
                $this->headerDetected = $state['headerDetected'] ?? $this->headerDetected;
                $this->associativeRows = $state['associativeRows'] ?? $this->associativeRows;
                $this->headerMap = $state['headerMap'] ?? $this->headerMap;
                $this->processed = $state['processed'] ?? $this->processed;
                $this->createdEmployees = $state['createdEmployees'] ?? $this->createdEmployees;
                $this->skippedExisting = $state['skippedExisting'] ?? $this->skippedExisting;
                $this->lookupsCreated = $state['lookupsCreated'] ?? $this->lookupsCreated;
                $this->failures = $state['failures'] ?? $this->failures;
            }
        }

        // If header not detected yet, look for it on this row (robust match)
        if (!$this->headerDetected) {
            if (count($cells) === 0) {
                Log::debug('[Employees Import] Empty row encountered before header', ['row' => $rowIndex]);
                return;
            }

            // Case A: library already applied headers (associative array of "header" => value)
            $keys = array_keys($cells);
            $normalizedKeys = array_map(fn($k) => $this->normalizeHeading((string) $k), $keys);
            if (in_array('ID NUMBER', $normalizedKeys, true) || in_array('ID_NUMBER', $normalizedKeys, true) || in_array('IDNUMBER', $normalizedKeys, true)) {
                $this->associativeRows = true;
                foreach ($keys as $k) {
                    $nk = $this->normalizeHeading((string) $k);
                    if ($nk !== '') {
                        // mark as present; index mapping not used for associative rows
                        $this->headerMap[$nk] = null;
                    }
                }
                $this->headerDetected = true;
                Log::info('[Employees Import] Header detected (associative)', [
                    'row' => $rowIndex,
                    'headers' => array_keys($cells),
                ]);
                // Do not return; current row is already a data row with headers applied
                if ($this->filePath) {
                    $this->persistState();
                }
            } else {
                // Case B: raw rows, need to detect header row by scanning values
                $isHeader = false;
                foreach ($cells as $val) {
                    $normalized = $this->normalizeHeading((string) $val);
                    if ($normalized === 'ID NUMBER' || $normalized === 'ID_NUMBER' || $normalized === 'IDNUMBER') {
                        $isHeader = true;
                        break;
                    }
                }
                if (!$isHeader) {
                    Log::debug('[Employees Import] Skipping non-header line', ['row' => $rowIndex, 'sample' => array_slice($cells, 0, 5)]);
                    return; // skip non-header lines before actual header
                }

                // Build header map: NAME (upper trimmed, normalized) => index
                foreach ($cells as $index => $heading) {
                    $key = $this->normalizeHeading((string) $heading);
                    if ($key !== '') {
                        $this->headerMap[$key] = $index;
                    }
                }
                $this->headerDetected = true;
                Log::info('[Employees Import] Header detected (indexed)', [
                    'row' => $rowIndex,
                    'header_map' => $this->headerMap,
                ]);
                if ($this->filePath) {
                    $this->persistState();
                }
                return; // header row itself, skip processing
            }
        }

        // From here, process data rows
        $this->processed++;
        try {
            $idNumber = (string) $this->getCell($cells, ['ID NUMBER', 'ID_NUMBER', 'IDNUMBER']);
            if ($idNumber === '') {
                Log::warning('[Employees Import] Missing ID NUMBER, skipping row', ['row' => $rowIndex]);
                return; // only required validation
            }

            if (CEMREmployee::where('id_num', $idNumber)->exists()) {
                $this->skippedExisting++;
                Log::debug('[Employees Import] Existing employee skipped', ['id_num' => $idNumber, 'row' => $rowIndex]);
                return;
            }

            $firstName = (string) $this->getCell($cells, ['FIRST NAME','FIRST_NAME','FIRSTNAME']);
            $middleName = (string) $this->getCell($cells, ['MIDDLE NAME','MIDDLE_NAME','MIDDLENAME']);
            $lastName = (string) $this->getCell($cells, ['LAST NAME','LAST_NAME','LASTNAME']);
            $suffix = (string) $this->getCell($cells, 'SUFFIX');
            $rankName = (string) $this->getCell($cells, 'RANK');
            $positionName = (string) $this->getCell($cells, ['CURRENT POSITION','CURRENT_POSITION']);
            $costCodeName = (string) $this->getCell($cells, ['COST CODE / JOB ORDER','COST CODE','COST_CODE','JOB ORDER','JOB_ORDER']);
            $projectName = (string) $this->getCell($cells, ['PROJECT/DIVISION/DEPARTMENT','PROJECT']);
            $divisionName = (string) $this->getCell($cells, 'DIVISION');
            $cbeValue = (string) $this->getCell($cells, 'CBE');
            $statusName = (string) $this->getCell($cells, ['EMPLOYMENT STATUS','EMPLOYMENT_STATUS']);

            $cbe = Str::of($cbeValue)->trim()->upper()->value() === 'Y';

            DB::connection('central_employeedb')->transaction(function () use (
                $idNumber,
                $firstName,
                $middleName,
                $lastName,
                $suffix,
                $cbe,
                $rankName,
                $positionName,
                $costCodeName,
                $projectName,
                $divisionName,
                $statusName
            ) {
                CEMREmployee::create([
                    'id_num' => $idNumber,
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'suffix_name' => $suffix,
                    'cbe' => $cbe,
                    'active' => true,
                ]);

                $rankId = $this->resolveLookup($rankName, CEMRRank::class, $this->rankNameToId, 'ranks');
                $positionId = $this->resolveLookup($positionName, CEMRPosition::class, $this->positionNameToId, 'positions');
                $costCodeId = $this->resolveLookup($costCodeName, CEMRCostCode::class, $this->costCodeNameToId, 'cost_codes');
                $projectId = $this->resolveLookup($projectName, CEMRProject::class, $this->projectNameToId, 'projects');
                $divisionId = $this->resolveLookup($divisionName, CEMRDivision::class, $this->divisionNameToId, 'divisions');
                $statusId = $this->resolveLookup($statusName, CEMRStatus::class, $this->statusNameToId, 'statuses');

                CEMREmpService::create([
                    'id_num' => $idNumber,
                    'rank_id' => $rankId,
                    'emp_stat_id' => $statusId,
                    'curr_pos_id' => $positionId,
                    'cost_code_id' => $costCodeId,
                    'project_id' => $projectId,
                    'division_id' => $divisionId,
                    'company_id' => $this->companyId,
                ]);
            });

            $this->createdEmployees++;
            Log::info('[Employees Import] Created employee and service', [
                'id_num' => $idNumber,
                'row' => $rowIndex,
            ]);
        } catch (\Throwable $e) {
            $this->failures[] = "Row {$rowIndex}: " . $e->getMessage();
            Log::error('[Employees Import] Row failed', [
                'row' => $rowIndex,
                'error' => $e->getMessage(),
            ]);
        }

        // Persist updated counters/state for subsequent chunks
        if ($this->filePath) {
            $this->persistState();
        }
    }

    /**
     * Resolve by name (case-insensitive). If not found, create under default company.
     */
    protected function resolveLookup(string $name, string $modelClass, array &$cache, string $counterKey): ?int
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        $key = Str::lower($name);
        if (isset($cache[$key])) {
            return $cache[$key];
        }

        // Try to find existing (case-insensitive) within company
        /** @var \Illuminate\Database\Eloquent\Model $modelClass */
        $existing = $modelClass::whereRaw('LOWER(name) = ?', [$key])
            ->where('company_id', $this->companyId)
            ->first();
        if ($existing) {
            return $cache[$key] = $existing->id;
        }

        // Create new
        $created = $modelClass::create([
            'name' => $name,
            'company_id' => $this->companyId,
        ]);

        $this->lookupsCreated[$counterKey]++;
        return $cache[$key] = $created->id;
    }

    protected function getCell(array $cells, string|array $keys): string
    {
        $keys = (array) $keys;
        foreach ($keys as $key) {
            $upper = $this->normalizeHeading($key);
            if (array_key_exists($upper, $this->headerMap)) {
                if ($this->associativeRows) {
                    // Direct associative access by normalized header
                    foreach ($cells as $k => $v) {
                        if ($this->normalizeHeading((string) $k) === $upper) {
                            return trim((string) $v);
                        }
                    }
                } else {
                    $idx = $this->headerMap[$upper];
                    return isset($cells[$idx]) ? trim((string) $cells[$idx]) : '';
                }
            }
        }
        return '';
    }

    protected function normalizeHeading(string $value): string
    {
        $v = strtoupper(trim($value, " \t\n\r\0\x0B\"'"));
        // collapse multiple spaces to single
        $v = preg_replace('/\s+/', ' ', $v ?? '');
        // remove non-breaking spaces
        $v = str_replace("\xC2\xA0", ' ', $v);
        return $v ?? '';
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function () {
                $this->handleImportCompletion();
            },
            ImportFailed::class => function (ImportFailed $event) {
                $this->handleImportFailure($event);
            },
        ];
    }

    protected function handleImportCompletion(): void
    {
        // Read final state from cache to produce accurate summary
        if ($this->filePath) {
            $state = Cache::get($this->cacheKey('state'));
            if (is_array($state)) {
                $this->processed = $state['processed'] ?? $this->processed;
                $this->createdEmployees = $state['createdEmployees'] ?? $this->createdEmployees;
                $this->skippedExisting = $state['skippedExisting'] ?? $this->skippedExisting;
                $this->lookupsCreated = $state['lookupsCreated'] ?? $this->lookupsCreated;
                $this->failures = $state['failures'] ?? $this->failures;
            }
        }

        Log::info('[Employees Import] Completed', [
            'processed' => $this->processed,
            'created' => $this->createdEmployees,
            'skipped' => $this->skippedExisting,
            'lookupsCreated' => $this->lookupsCreated,
            'failures_count' => count($this->failures),
        ]);

        if ($this->userId) {
            $this->sendSuccessNotification();
        }

        // Clear persisted state after completion
        if ($this->filePath) {
            Cache::forget($this->cacheKey('state'));
        }
    }

    protected function handleImportFailure(ImportFailed $event): void
    {
        Log::error('[Employees Import] Failed', [
            'error' => $event->getException()->getMessage(),
            'trace' => $event->getException()->getTraceAsString()
        ]);

        if ($this->userId) {
            $this->sendFailureNotification($event->getException()->getMessage());
        }

        // Clear persisted state after failure
        if ($this->filePath) {
            Cache::forget($this->cacheKey('state'));
        }
    }

    protected function sendSuccessNotification(): void
    {
        try {
            $user = User::find($this->userId);
            if (!$user) {
                Log::warning('[Employees Import] User not found for notification', ['user_id' => $this->userId]);
                return;
            }

            $summary = "Processed: {$this->processed}\n" .
                "Created employees: {$this->createdEmployees}\n" .
                "Skipped existing: {$this->skippedExisting}\n" .
                "Lookups created - Ranks: {$this->lookupsCreated['ranks']}, Positions: {$this->lookupsCreated['positions']}, Cost Codes: {$this->lookupsCreated['cost_codes']}, Projects: {$this->lookupsCreated['projects']}, Divisions: {$this->lookupsCreated['divisions']}, Statuses: {$this->lookupsCreated['statuses']}\n" .
                (count($this->failures) ? ("Failures:\n" . implode("\n", array_slice($this->failures, 0, 10))) : '');

            // Use Filament's notification system with sendToDatabase
            Notification::make()
                ->title('Employee import completed')
                ->body($summary)
                ->success()
                ->icon('heroicon-o-check-circle')
                ->persistent()
                ->sendToDatabase($user);

            Log::info('[Employees Import] Success notification sent', [
                'user_id' => $this->userId,
                'summary_preview' => substr($summary, 0, 100)
            ]);

        } catch (\Throwable $e) {
            Log::error('[Employees Import] Failed to send success notification', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function sendFailureNotification(string $errorMessage): void
    {
        try {
            $user = User::find($this->userId);
            if (!$user) {
                Log::warning('[Employees Import] User not found for failure notification', ['user_id' => $this->userId]);
                return;
            }

            // Use Filament's notification system with sendToDatabase
            Notification::make()
                ->title('Employee import failed')
                ->body($errorMessage)
                ->danger()
                ->icon('heroicon-o-x-circle')
                ->persistent()
                ->sendToDatabase($user);

            Log::info('[Employees Import] Failure notification sent', [
                'user_id' => $this->userId,
                'error_preview' => substr($errorMessage, 0, 100)
            ]);

        } catch (\Throwable $e) {
            Log::error('[Employees Import] Failed to send failure notification', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function persistState(): void
    {
        Cache::put($this->cacheKey('state'), [
            'headerDetected' => $this->headerDetected,
            'associativeRows' => $this->associativeRows,
            'headerMap' => $this->headerMap,
            'processed' => $this->processed,
            'createdEmployees' => $this->createdEmployees,
            'skippedExisting' => $this->skippedExisting,
            'lookupsCreated' => $this->lookupsCreated,
            'failures' => $this->failures,
        ], now()->addHour());
    }

    protected function cacheKey(string $suffix): string
    {
        return 'employees_import:' . md5((string) $this->filePath) . ':' . $suffix;
    }
}
