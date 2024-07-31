<?php

namespace App\Filament\Resources\PeripheralsTypesResource\Pages;

use App\Filament\Resources\PeripheralsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeripheralsTypes extends CreateRecord
{
    protected static string $resource = PeripheralsTypesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
