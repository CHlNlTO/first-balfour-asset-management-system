<?php

namespace App\Filament\Resources\PeripheralsTypesResource\Pages;

use App\Filament\Resources\PeripheralsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeripheralsTypes extends EditRecord
{
    protected static string $resource = PeripheralsTypesResource::class;

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
