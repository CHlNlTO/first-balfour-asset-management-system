<?php

namespace App\Filament\Resources\LifecycleResource\Pages;

use App\Filament\Resources\LifecycleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLifecycle extends CreateRecord
{
    protected static string $resource = LifecycleResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('create');
    }
}
