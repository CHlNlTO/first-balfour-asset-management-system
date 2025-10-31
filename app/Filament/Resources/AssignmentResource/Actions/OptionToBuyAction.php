<?php

namespace App\Filament\Resources\AssignmentResource\Actions;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Helpers\StatusSynchronizationHelper;
use App\Services\SalesService;
use Carbon\Carbon;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptionToBuyAction
{
    public static function make(): Action
    {
        return Action::make('Option to Buy')
            ->form(
                static::getFormSchema(),
            )
            ->action(function (Assignment $record, array $data): void {
                static::handleOptionToBuy($record, $data);
            })
            ->icon('heroicon-o-banknotes')
            ->requiresConfirmation()
            ->modalHeading('Option to Buy Asset')
            ->modalButton('Accept Option')
            ->successNotificationTitle('Asset Option to Buy Initiated.');
    }

    protected static function getFormSchema(): array
    {
        return [
            Hidden::make('id')
                ->default(fn(Model $record): int => $record->id)
                ->required(),

            Hidden::make('asset_id')
                ->default(fn(Model $record): int => $record->asset_id)
                ->required(),

            TextInput::make('asset_display')
                ->label('Assets')
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

            Hidden::make('from_employee_id')
                ->default(fn(Model $record): string => $record->employee->id_num)
                ->required(),

            TextInput::make('from_employee_display')
                ->label('Sell to Employee')
                ->default(fn(Model $record): string => "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}")
                ->disabled()
                ->dehydrated(false),

            Hidden::make('assignment_status')
                ->default(function (): int {
                    return AssignmentStatus::where('assignment_status', 'Asset Sold')->value('id');
                })
                ->required(),

            TextInput::make('assignment_status_display')
                ->label('Assignment Status')
                ->default('Option to Buy')
                ->disabled()
                ->dehydrated(false),

            Hidden::make('old_start_date')
                ->default(fn(Model $record): string => Carbon::parse($record->start_date)->format('Y-m-d')),

            Hidden::make('old_end_date')
                ->default(fn(Model $record): ?string => $record->end_date ? Carbon::parse($record->end_date)->format('Y-m-d') : null),

            TextInput::make('asset_cost')
                ->label('Asset Cost')
                ->prefix('₱')
                ->placeholder('0.00')
                ->hint(fn(Model $record): string =>  "Original Price: ₱" . ($record->asset->purchases->first()->purchase_order_amount ?? 0) . ".00")
                ->numeric()
                ->required(),

            FileUpload::make('document_path')
                ->label('Attach Document')
                ->directory('option-to-buy-documents')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                ->maxSize(10240) // 10MB max size
                ->hint('Accepted file types: PDF, JPEG, PNG (Max: 10MB)')
                ->columnSpanFull(),
        ];
    }

    protected static function handleOptionToBuy(Assignment $record, array $data): void
    {
        DB::beginTransaction();

        try {
            Log::info("Data received in Option to Buy action:", $data);

            static::updateAssignment($record, $data);
            SalesService::createOptionToBuy($record, $data);

            // Sync Asset Status with the updated Assignment Status (most recent only)
            StatusSynchronizationHelper::syncAssetStatusFromAssignment($record);

            DB::commit();
            static::sendSuccessNotification();
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
        }
    }

    protected static function updateAssignment(Assignment $record, array $data): void
    {
        $optionToBuyStatusId = AssignmentStatus::where('assignment_status', 'Option to Buy')->value('id');

        $record->update([
            'asset_id' => $data['asset_id'] ?? $record->asset_id,
            'employee_id' => $data['from_employee_id'],
            'assignment_status' => $optionToBuyStatusId, // Option to Buy status
            'start_date' => $data['old_start_date'],
        ]);
    }

    protected static function sendSuccessNotification(): void
    {
        Notification::make()
            ->title('Option In Progress')
            ->success()
            ->send();
    }

    protected static function handleError(\Exception $e): void
    {
        Log::error("Error in Option to Buy action: " . $e->getMessage());

        Notification::make()
            ->title('Error processing Option to Buy')
            ->body('An error occurred while processing the Option to Buy. Please try again.')
            ->danger()
            ->send();
    }
}
