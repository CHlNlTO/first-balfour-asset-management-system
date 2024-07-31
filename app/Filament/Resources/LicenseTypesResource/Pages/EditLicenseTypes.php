<?php

namespace App\Filament\Resources\LicenseTypesResource\Pages;

use App\Filament\Resources\LicenseTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLicenseTypes extends EditRecord
{
    protected static string $resource = LicenseTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
