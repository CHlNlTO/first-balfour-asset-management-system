<?php

namespace App\Filament\Resources\SoftwareTypesResource\Pages;

use App\Filament\Resources\SoftwareTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSoftwareTypes extends CreateRecord
{
    protected static string $resource = SoftwareTypesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
