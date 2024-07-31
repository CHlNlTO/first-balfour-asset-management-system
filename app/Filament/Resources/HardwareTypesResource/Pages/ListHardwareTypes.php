<?php

namespace App\Filament\Resources\HardwareTypesResource\Pages;

use App\Filament\Resources\HardwareTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHardwareTypes extends ListRecords
{
    protected static string $resource = HardwareTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
