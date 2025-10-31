<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use App\Helpers\StatusSynchronizationHelper;
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

            // Sync Asset Status with Assignment Status for the most recent assignment
            StatusSynchronizationHelper::syncAssetStatusFromAssignment($optionToBuy->assignment);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
