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

        // Get the assignment status name
        $assignmentStatus = AssignmentStatus::find($optionToBuy->option_to_buy_status);

        if ($assignmentStatus && in_array($assignmentStatus->assignment_status, ['Asset Sold', 'Option to Buy'])) {
            // Try to find asset status by name, prioritizing "Asset Sold" then "Sold"
            $soldAssetStatus = AssetStatus::where('asset_status', 'Asset Sold')->first()
                ?? AssetStatus::where('asset_status', 'Sold')->first();

            if ($soldAssetStatus) {
                // Update the asset status to the found sold status
                DB::beginTransaction();
                try {
                    $optionToBuy->assignment->asset->update([
                        'asset_status' => $soldAssetStatus->id
                    ]);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
            // If neither "Asset Sold" nor "Sold" status exists, do nothing
        }
    }
}
