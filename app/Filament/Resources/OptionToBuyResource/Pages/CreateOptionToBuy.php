<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use App\Models\AssetStatus;
use App\Models\AssignmentStatus;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateOptionToBuy extends CreateRecord
{
    protected static string $resource = OptionToBuyResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // Get the created record
        $optionToBuy = $this->record;

        DB::beginTransaction();
        try {
            // Always update the assignment status to match the option to buy status
            $optionToBuy->assignment->update([
                'assignment_status' => $optionToBuy->option_to_buy_status
            ]);

            // Get the assignment status name to check if we need to update asset status
            $assignmentStatus = AssignmentStatus::find($optionToBuy->option_to_buy_status);

            // Only update asset status if the assignment status is "Asset Sold" or "Option to Buy"
            if ($assignmentStatus && in_array($assignmentStatus->assignment_status, ['Asset Sold', 'Option to Buy'])) {
                // Try to find asset status by name, prioritizing "Asset Sold" then "Sold"
                $soldAssetStatus = AssetStatus::where('asset_status', 'Asset Sold')->first()
                    ?? AssetStatus::where('asset_status', 'Sold')->first();

                if ($soldAssetStatus) {
                    // Update the asset status to the found sold status
                    $optionToBuy->assignment->asset->update([
                        'asset_status' => $soldAssetStatus->id
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
