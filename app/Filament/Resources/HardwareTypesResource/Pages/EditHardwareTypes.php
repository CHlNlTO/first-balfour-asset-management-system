<?php

namespace App\Filament\Resources\HardwareTypesResource\Pages;

use App\Filament\Resources\HardwareTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHardwareTypes extends EditRecord
{
    protected static string $resource = HardwareTypesResource::class;

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
