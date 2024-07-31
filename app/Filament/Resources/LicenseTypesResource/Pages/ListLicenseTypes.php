<?php

namespace App\Filament\Resources\LicenseTypesResource\Pages;

use App\Filament\Resources\LicenseTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicenseTypes extends ListRecords
{
    protected static string $resource = LicenseTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
