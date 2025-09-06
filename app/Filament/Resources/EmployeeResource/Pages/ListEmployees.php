<?php
// File: app/Filament/Resources/EmployeeResource/Pages/ListEmployees.php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Imports\CEMREmployeesImport;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('importEmployees')
                ->label('Import Employees')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('primary')
                ->modalHeading('Import Employees from Excel/CSV')
                ->modalSubmitActionLabel('Start Import')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('Upload file (.xlsx, .xls, .csv)')
                        ->required()
                        ->disk('local')
                        ->directory('imports/employees')
                        ->preserveFilenames()
                        ->acceptedFileTypes([
                            'text/csv',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->helperText('Supported formats: CSV, Excel (.xlsx, .xls)'),
                ])
                ->action(function (array $data) {
                    $this->handleEmployeeImport($data);
                }),

            Actions\CreateAction::make()
                ->label('New Employee')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function handleEmployeeImport(array $data): void
    {
        try {
            $userId = Auth::id();
            $filePath = $data['file'];

            // Verify file exists
            if (!Storage::disk('local')->exists($filePath)) {
                throw new \Exception('Upload file not found. Please try uploading again.');
            }

            Log::info('[Employees Import] Starting import process', [
                'user_id' => $userId,
                'file' => $filePath,
                'file_size' => Storage::disk('local')->size($filePath),
                'queue_driver' => config('queue.default'),
            ]);

            // Create import instance
            $import = new CEMREmployeesImport($userId, $filePath);

            // Queue the import with proper error handling
            if (config('queue.default') === 'sync') {
                // Synchronous processing
                Excel::import($import, $filePath, 'local');

                Notification::make()
                    ->title('Employee import completed')
                    ->body('Import processed synchronously. Check notifications for details.')
                    ->success()
                    ->send();
            } else {
                // Asynchronous processing - queue the import
                Excel::queueImport($import, $filePath, 'local')
                    ->onConnection(config('queue.default', 'database'))
                    ->onQueue('imports');

                Notification::make()
                    ->title('Employee import started')
                    ->body('Your file is being processed in the background. You will receive a notification when complete.')
                    ->info()
                    ->send();
            }

            Log::info('[Employees Import] Import queued successfully', [
                'user_id' => $userId,
                'file' => $filePath,
            ]);

        } catch (\Throwable $e) {
            Log::error('[Employees Import] Failed to start import', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'file' => $data['file'] ?? 'unknown',
            ]);

            Notification::make()
                ->title('Employee import failed to start')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Employees')
                ->icon('heroicon-o-users'),

            'active' => Tab::make('Active')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true))
                ->badge(fn () => $this->getModel()::where('active', true)->count()),

            'inactive' => Tab::make('Inactive')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false))
                ->badge(fn () => $this->getModel()::where('active', false)->count()),

            'no_email' => Tab::make('No Email')
                ->icon('heroicon-o-envelope-open')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('email')->orWhere('email', ''))
                ->badge(fn () => $this->getModel()::whereNull('email')->orWhere('email', '')->count()),

            'cbe_qualified' => Tab::make('CBE Qualified')
                ->icon('heroicon-o-academic-cap')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('cbe', true))
                ->badge(fn () => $this->getModel()::where('cbe', true)->count()),

            'recent' => Tab::make('Recent Hires')
                ->icon('heroicon-o-calendar-days')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('original_hired_date', '>=', now()->subDays(30)))
                ->badge(fn () => $this->getModel()::where('original_hired_date', '>=', now()->subDays(30))->count()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Add any widgets here if needed
        ];
    }
}
