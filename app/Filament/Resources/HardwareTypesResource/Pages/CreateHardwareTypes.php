<?php

namespace App\Filament\Resources\HardwareTypesResource\Pages;

use App\Filament\Resources\HardwareTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHardwareTypes extends CreateRecord
{
    protected static string $resource = HardwareTypesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
