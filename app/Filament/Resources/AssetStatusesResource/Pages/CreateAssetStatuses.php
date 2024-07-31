<?php

namespace App\Filament\Resources\AssetStatusesResource\Pages;

use App\Filament\Resources\AssetStatusesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAssetStatuses extends CreateRecord
{
    protected static string $resource = AssetStatusesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
