<?php

namespace App\Filament\Resources\AssetStatusesResource\Pages;

use App\Filament\Resources\AssetStatusesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssetStatuses extends ListRecords
{
    protected static string $resource = AssetStatusesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
