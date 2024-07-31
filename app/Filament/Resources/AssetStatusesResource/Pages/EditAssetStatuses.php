<?php

namespace App\Filament\Resources\AssetStatusesResource\Pages;

use App\Filament\Resources\AssetStatusesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssetStatuses extends EditRecord
{
    protected static string $resource = AssetStatusesResource::class;

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
