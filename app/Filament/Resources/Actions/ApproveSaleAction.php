<?php

namespace App\Filament\Resources\Actions;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\OptionToBuy;
use App\Services\SalesService;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Generic Action that can be used from both Assignment and OptionToBuy resources
 */
class ApproveSaleAction
{
    /**
     * Create the action for Assignment Resource
     *
     * @return Action
     */
    public static function makeForAssignment(): Action
    {
        return Action::make('Approve Sale')
            ->form(
                static::getFormSchemaForAssignment(),
            )
            ->action(function (Assignment $record, array $data): void {
                try {
                    // If document was uploaded, update the option to buy record
                    if (!empty($data['document_path'])) {
                        $record->optionToBuy->update([
                            'document_path' => $data['document_path']
                        ]);
                    }

                    SalesService::approveSale($record);
                } catch (\Exception $e) {
                    // Error is already logged and notification sent by service
                }
            })
            ->visible(
                fn(Assignment $record): bool =>
                $record->assignment_status === AssignmentStatus::where('assignment_status', 'Option to Buy')->first()->id
            )
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->modalHeading('Approve Asset Sale')
            ->modalButton('Approve Sale')
            ->successNotificationTitle('Asset Sale Approved Successfully');
    }

    /**
     * Create the action for OptionToBuy Resource
     *
     * @return Action
     */
    public static function makeForOptionToBuy(): Action
    {
        return Action::make('Approve Sale')
            ->form(
                static::getFormSchemaForOptionToBuy(),
            )
            ->action(function (OptionToBuy $record, array $data): void {
                try {
                    // If document was uploaded, update the option to buy record
                    if (!empty($data['document_path'])) {
                        $record->update([
                            'document_path' => $data['document_path']
                        ]);
                    }

                    SalesService::approveSale(null, $record);
                } catch (\Exception $e) {
                    // Error is already logged and notification sent by service
                }
            })
            ->visible(
                fn(OptionToBuy $record): bool =>
                $record->option_to_buy_status === AssignmentStatus::where('assignment_status', 'Option to Buy')->first()->id
            )
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->modalHeading('Approve Asset Sale')
            ->modalButton('Approve Sale')
            ->successNotificationTitle('Asset Sale Approved Successfully');
    }

    /**
     * Get the form schema for Assignment resource
     *
     * @return array
     */
    protected static function getFormSchemaForAssignment(): array
    {
        return [
            Hidden::make('id')
                ->default(fn(Model $record): int => $record->id)
                ->required(),

            TextInput::make('asset_display')
                ->label('Asset')
                ->default(function(Model $record): string {
                    $asset = $record->asset;
                    $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                    $model = $asset->model?->name ?? 'Unknown Model';
                    return "{$asset->id} - {$brand} {$model}";
                })
                ->disabled()
                ->dehydrated(false),

            TextInput::make('employee_display')
                ->label('Sold to Employee')
                ->default(fn(Model $record): string => "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}")
                ->disabled()
                ->dehydrated(false),

            TextInput::make('sale_amount_display')
                ->label('Sale Amount')
                ->default(fn(Model $record): string => "₱{$record->optionToBuy->asset_cost}")
                ->disabled()
                ->dehydrated(false),

            FileUpload::make('document_path')
                ->label('Attach Document')
                ->directory('option-to-buy-documents')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                ->maxSize(10240) // 10MB max size
                ->disk('public')
                ->visibility('public')
                ->hint('Accepted file types: PDF, JPEG, PNG (Max: 10MB)')
                ->columnSpanFull()
                // Only require document if there isn't one already
                ->required(fn(Model $record): bool => !$record->optionToBuy->document_path)
                // Show the existing document if any
                ->helperText(fn(Model $record): string => $record->optionToBuy->document_path
                    ? "Current document: " . basename($record->optionToBuy->document_path)
                    : "No document currently attached."),
        ];
    }

    /**
     * Get the form schema for OptionToBuy resource
     *
     * @return array
     */
    protected static function getFormSchemaForOptionToBuy(): array
    {
        return [
            Hidden::make('id')
                ->default(fn(Model $record): int => $record->assignment->id)
                ->required(),

            TextInput::make('asset_display')
                ->label('Asset')
                ->default(function(Model $record): string {
                    $asset = $record->assignment->asset;
                    $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                    $model = $asset->model?->name ?? 'Unknown Model';
                    return "{$asset->id} - {$brand} {$model}";
                })
                ->disabled()
                ->dehydrated(false),

            TextInput::make('employee_display')
                ->label('Sold to Employee')
                ->default(fn(Model $record): string => "{$record->assignment->employee->id_num} - {$record->assignment->employee->first_name} {$record->assignment->employee->last_name}")
                ->disabled()
                ->dehydrated(false),

            TextInput::make('sale_amount_display')
                ->label('Sale Amount')
                ->default(fn(Model $record): string => "₱{$record->asset_cost}")
                ->disabled()
                ->dehydrated(false),

            FileUpload::make('document_path')
                ->label('Attach Document')
                ->directory('option-to-buy-documents')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                ->maxSize(10240) // 10MB max size
                ->disk('public')
                ->visibility('public')
                ->hint('Accepted file types: PDF, JPEG, PNG (Max: 10MB)')
                ->columnSpanFull()
                // Only require document if there isn't one already
                ->required(fn(Model $record): bool => !$record->document_path)
                // Show the existing document if any
                ->helperText(fn(Model $record): string => $record->document_path
                    ? "Current document: " . basename($record->document_path)
                    : "No document currently attached."),
        ];
    }
}
