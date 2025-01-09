<?php

namespace App\Filament\Resources\AssignmentResource\Actions;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\OptionToBuy;
use App\Models\Asset;
use App\Models\AssetStatus;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApproveSaleAction
{
    public static function make(): Action
    {
        return Action::make('Approve Sale')
            ->form(
                static::getFormSchema(),
            )
            ->action(function (Assignment $record, array $data): void {
                static::handleApproveSale($record, $data);
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

    protected static function getFormSchema(): array
    {
        return [
            Hidden::make('id')
                ->default(fn(Model $record): int => $record->id)
                ->required(),

            TextInput::make('asset_display')
                ->label('Asset')
                ->default(fn(Model $record): string => "{$record->asset->id} - {$record->asset->brand} {$record->asset->model}")
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
        ];
    }

    protected static function handleApproveSale(Assignment $record, array $data): void
    {
        DB::beginTransaction();

        try {
            Log::info("Processing sale approval for Assignment ID: {$record->id}");

            // Update Asset Status to Sold
            static::updateAssetStatus($record->asset);

            // Update OptionToBuy Status to Approved
            static::updateOptionToBuyStatus($record->optionToBuy);

            // Update Assignment Status to Asset Sold
            static::updateAssignmentStatus($record);

            DB::commit();
            static::sendSuccessNotification();
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
        }
    }

    protected static function updateAssetStatus(Asset $asset): void
    {
        try {
            $soldStatus = AssetStatus::where('asset_status', 'Sold')->first();

            if (!$soldStatus) {
                throw new \Exception('Sold status not found in asset_statuses table');
            }

            Log::info("Updating asset {$asset->id} status to Sold (Status ID: {$soldStatus->id})");

            $asset->update([
                'asset_status' => $soldStatus->id
            ]);

            Log::info("Successfully updated asset {$asset->id} status to Sold");
        } catch (\Exception $e) {
            Log::error("Failed to update asset status: " . $e->getMessage());
            throw $e;
        }
    }

    protected static function updateOptionToBuyStatus(OptionToBuy $optionToBuy): void
    {
        try {
            $soldStatus = AssignmentStatus::where('assignment_status', 'Asset Sold')->first();

            if (!$soldStatus) {
                throw new \Exception('Sold status not found in assignment_statuses table');
            }

            Log::info("Updating option to buy {$optionToBuy->id} status to Sold (Status ID: {$soldStatus->id})");

            $optionToBuy->update([
                'option_to_buy_status' => $soldStatus->id
            ]);

            Log::info("Successfully updated option to buy {$optionToBuy->id} status to Sold");
        } catch (\Exception $e) {
            Log::error("Failed to update option to buy status: " . $e->getMessage());
            throw $e;
        }
    }

    protected static function updateAssignmentStatus(Assignment $assignment): void
    {
        try {
            $soldStatus = AssignmentStatus::where('assignment_status', 'Asset Sold')->first();

            if (!$soldStatus) {
                throw new \Exception('Sold status not found in assignment_statuses table');
            }

            Log::info("Updating assignment {$assignment->id} status to Sold (Status ID: {$soldStatus->id})");

            $assignment->update([
                'assignment_status' => $soldStatus->id
            ]);

            Log::info("Successfully updated assignment {$assignment->id} status to Sold");
        } catch (\Exception $e) {
            Log::error("Failed to update assignment status: " . $e->getMessage());
            throw $e;
        }
    }

    protected static function sendSuccessNotification(): void
    {
        Notification::make()
            ->title('Sale Approved Successfully')
            ->success()
            ->send();
    }

    protected static function handleError(\Exception $e): void
    {
        Log::error("Error in Approve Sale action: " . $e->getMessage());

        Notification::make()
            ->title('Error Processing Sale Approval')
            ->body('An error occurred while processing the sale approval. Please try again.')
            ->danger()
            ->send();
    }
}
