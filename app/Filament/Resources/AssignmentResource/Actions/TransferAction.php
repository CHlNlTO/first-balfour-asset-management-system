<?php

namespace App\Filament\Resources\AssignmentResource\Actions;

use App\Filament\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\Transfer;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferAction
{
    public static function make(): Action
    {
        return Action::make('transfer')
            ->label('Transfer')
            ->icon('heroicon-o-arrows-right-left')
            ->color('primary')
            ->form([
                Group::make()
                    ->schema([
                        ...static::getAssetSection(),
                        ...static::getEmployeeSection(),
                        ...static::getStatusSection(),
                        ...static::getDatesSection(),
                    ]),
            ])
            ->visible(
                fn(Assignment $record): bool =>
                $record->assignment_status === AssignmentStatus::where('assignment_status', 'Active')->first()->id
            )
            ->requiresConfirmation()
            ->modalHeading('Transfer Asset')
            ->modalDescription('This will initiate a transfer of the asset to another employee.')
            ->modalButton('Transfer')
            ->action(function (Assignment $record, array $data): void {
                static::handleTransfer($record, $data);
            });
    }

    protected static function getAssetSection(): array
    {
        return [
            Hidden::make('asset_id')
                ->default(fn(Model $record): int => $record->asset_id)
                ->required(),

            TextInput::make('asset_display')
                ->label('Asset')
                ->default(function(Model $record): string {
                    $asset = $record->asset;
                    $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                    // For software, only show brand
                    if ($asset->asset_type === 'software') {
                        return "{$asset->id} - {$brand}";
                    }
                    // For hardware/peripherals, show brand + model
                    $model = $asset->model?->name ?? 'Unknown Model';
                    return "{$asset->id} - {$brand} {$model}";
                })
                ->disabled()
                ->dehydrated(false),
        ];
    }

    protected static function getEmployeeSection(): array
    {
        return [
            Hidden::make('from_employee_id')
                ->default(fn(Model $record): string => $record->employee->id_num)
                ->required(),

            TextInput::make('from_employee_display')
                ->label('From Employee')
                ->default(
                    fn(Model $record): string =>
                    "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}"
                )
                ->disabled()
                ->dehydrated(false),

            Select::make('employee_id')
                ->label('To Employee')
                ->placeholder('Select from registered employees')
                ->relationship('employee', 'id_num')
                ->getOptionLabelFromRecordUsing(
                    fn(Model $record): string =>
                    "{$record->id_num} - {$record->first_name} {$record->last_name}"
                )
                ->searchable(['id_num', 'first_name', 'last_name'])
                ->required()
                ->helperText('Select the employee who will receive the asset'),
        ];
    }

    protected static function getStatusSection(): array
    {
        return [
            Hidden::make('assignment_status')
                ->default(
                    fn(): int =>
                    AssignmentStatus::where('assignment_status', 'Pending Approval')->first()->id
                )
                ->required(),

            TextInput::make('assignment_status_display')
                ->label('Assignment Status')
                ->default('Pending Approval')
                ->disabled()
                ->dehydrated(false),
        ];
    }

    protected static function getDatesSection(): array
    {
        return [
            Hidden::make('old_start_date')
                ->default(
                    fn(Model $record): string =>
                    Carbon::parse($record->start_date)->format('Y-m-d')
                ),

            Hidden::make('old_end_date')
                ->default(
                    fn(Model $record): ?string =>
                    $record->end_date ? Carbon::parse($record->end_date)->format('Y-m-d') : null
                ),

            Group::make()
                ->schema([
                    DatePicker::make('start_date')
                        ->label('Start Date')
                        ->native(false)
                        ->closeOnDateSelection()
                        ->required()
                        ->default(now()),

                    DatePicker::make('end_date')
                        ->label('End Date')
                        ->native(false)
                        ->closeOnDateSelection()
                        ->minDate(fn($get) => $get('start_date'))
                        ->after('start_date'),
                ])
                ->columns(2),
        ];
    }

    protected static function handleTransfer(Assignment $record, array $data)
    {
        DB::beginTransaction();

        try {
            Log::info("Starting transfer process with data:", array_merge(
                $data,
                ['current_assignment_id' => $record->id]
            ));

            static::validateTransferData($data);
            static::updateCurrentAssignment($record);
            static::createNewAssignment($data);
            static::createTransferRecord($record, $data);

            DB::commit();
            static::sendSuccessNotification();

            return redirect()->to(AssignmentResource::getUrl('index'));
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
            throw $e;
        }
    }

    protected static function validateTransferData(array $data): void
    {
        // if (empty($data['employee_id'])) {
        //     throw new \InvalidArgumentException('Target employee must be specified');
        // }

        // if (empty($data['start_date'])) {
        //     throw new \InvalidArgumentException('Start date must be specified');
        // }
    }

    protected static function updateCurrentAssignment(Assignment $record): void
    {
        $inTransferStatus = AssignmentStatus::where('assignment_status', 'Transferred')->first();

        $record->update([
            'assignment_status' => $inTransferStatus->id,
            'end_date' => now(),
        ]);

        Log::info("Updated current assignment status to In Transfer", [
            'assignment_id' => $record->id,
            'status' => $inTransferStatus->assignment_status
        ]);
    }

    protected static function createNewAssignment(array $data): void
    {
        $pendingApprovalStatus = AssignmentStatus::where('assignment_status', 'Pending Approval')->first();

        Assignment::create([
            'asset_id' => $data['asset_id'],
            'employee_id' => $data['employee_id'],
            'assignment_status' => $pendingApprovalStatus->id,
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => isset($data['end_date'])
                ? Carbon::parse($data['end_date'])->format('Y-m-d')
                : null,
        ]);

        Log::info("Created new pending assignment", [
            'to_employee' => $data['employee_id'],
            'start_date' => $data['start_date'],
        ]);
    }

    protected static function createTransferRecord(Assignment $record, array $data): void
    {
        Transfer::create([
            'assignment_id' => $record->id,
            'from_employee' => $record->employee_id,
            'to_employee' => $data['employee_id'],
            'status' => AssignmentStatus::where('assignment_status', 'Pending Approval')->first()->id,
            'transfer_date' => now(),
        ]);

        Log::info("Created transfer record", [
            'from_employee' => $record->employee_id,
            'to_employee' => $data['employee_id'],
        ]);
    }

    protected static function sendSuccessNotification(): void
    {
        Notification::make()
            ->title('Transfer Initiated')
            ->body('The asset transfer has been initiated and is awaiting approval.')
            ->success()
            ->send();
    }

    protected static function handleError(\Exception $e): void
    {
        Log::error("Error in Transfer action: " . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);

        Notification::make()
            ->title('Error Transferring Asset')
            ->body('An error occurred while processing the transfer. Please try again or contact support.')
            ->danger()
            ->persistent()
            ->send();
    }
}
