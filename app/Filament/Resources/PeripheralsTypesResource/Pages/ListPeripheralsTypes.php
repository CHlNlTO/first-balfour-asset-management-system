<?php

namespace App\Filament\Resources\PeripheralsTypesResource\Pages;

use App\Filament\Resources\PeripheralsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeripheralsTypes extends ListRecords
{
    protected static string $resource = PeripheralsTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
