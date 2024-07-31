<?php

namespace App\Filament\Resources\SoftwareTypesResource\Pages;

use App\Filament\Resources\SoftwareTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoftwareTypes extends ListRecords
{
    protected static string $resource = SoftwareTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
