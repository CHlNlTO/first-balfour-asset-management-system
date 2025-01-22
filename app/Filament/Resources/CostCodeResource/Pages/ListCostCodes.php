<?php

namespace App\Filament\Resources\CostCodeResource\Pages;

use App\Filament\Resources\CostCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostCodes extends ListRecords
{
    protected static string $resource = CostCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
