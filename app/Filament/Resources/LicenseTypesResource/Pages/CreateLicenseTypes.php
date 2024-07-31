<?php

namespace App\Filament\Resources\LicenseTypesResource\Pages;

use App\Filament\Resources\LicenseTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLicenseTypes extends CreateRecord
{
    protected static string $resource = LicenseTypesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
