<?php

namespace App\Filament\Resources\SoftwareTypesResource\Pages;

use App\Filament\Resources\SoftwareTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoftwareTypes extends EditRecord
{
    protected static string $resource = SoftwareTypesResource::class;

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
