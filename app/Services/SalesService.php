<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\OptionToBuy;
use App\Models\Asset;
use App\Models\AssetStatus;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesService
{
    /**
     * Process the approval of a sale
     *
     * @param Assignment|null $assignment
     * @param OptionToBuy|null $optionToBuy
     * @return void
     * @throws \Exception
     */
    public static function approveSale(?Assignment $assignment = null, ?OptionToBuy $optionToBuy = null): void
    {
        if (!$assignment && !$optionToBuy) {
            throw new \Exception('Either Assignment or OptionToBuy must be provided');
        }

        // If we only have optionToBuy, get the assignment
        if (!$assignment && $optionToBuy) {
            $assignment = $optionToBuy->assignment;
        }

        // If we only have assignment, get the optionToBuy
        if (!$optionToBuy && $assignment) {
            $optionToBuy = $assignment->optionToBuy;
        }

        if (!$assignment || !$optionToBuy) {
            throw new \Exception('Could not resolve both Assignment and OptionToBuy records');
        }

        DB::beginTransaction();

        try {
            Log::info("Processing sale approval for Assignment ID: {$assignment->id} / OptionToBuy ID: {$optionToBuy->id}");

            // Update Asset Status to Sold
            static::updateAssetStatus($assignment->asset);

            // Update OptionToBuy Status to Approved
            static::updateOptionToBuyStatus($optionToBuy);

            // Update Assignment Status to Asset Sold
            static::updateAssignmentStatus($assignment);

            DB::commit();
            static::sendSuccessNotification();
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
            throw $e; // Rethrow to be handled by the action
        }
    }

    /**
     * Create a new Option to Buy record
     *
     * @param Assignment $assignment
     * @param array $data
     * @return OptionToBuy
     */
    public static function createOptionToBuy(Assignment $assignment, array $data): OptionToBuy
    {
        return OptionToBuy::create([
            'assignment_id' => $assignment->id,
            'option_to_buy_status' => 10, // Initial status (Option to Buy)
            'asset_cost' => $data['asset_cost'],
            'document_path' => $data['document_path'] ?? null, // Include document if provided
        ]);
    }

    /**
     * Update the asset status to Sold
     *
     * @param Asset $asset
     * @return void
     * @throws \Exception
     */
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

    /**
     * Update the option to buy status to Asset Sold
     *
     * @param OptionToBuy $optionToBuy
     * @return void
     * @throws \Exception
     */
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

    /**
     * Update the assignment status to Asset Sold
     *
     * @param Assignment $assignment
     * @return void
     * @throws \Exception
     */
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

    /**
     * Send a success notification
     *
     * @return void
     */
    protected static function sendSuccessNotification(): void
    {
        Notification::make()
            ->title('Sale Approved Successfully')
            ->success()
            ->send();
    }

    /**
     * Handle an error during the process
     *
     * @param \Exception $e
     * @return void
     */
    protected static function handleError(\Exception $e): void
    {
        Log::error("Error in Sale process: " . $e->getMessage());

        Notification::make()
            ->title('Error Processing Sale Action')
            ->body('An error occurred while processing the sale. Please try again.')
            ->danger()
            ->send();
    }
}
