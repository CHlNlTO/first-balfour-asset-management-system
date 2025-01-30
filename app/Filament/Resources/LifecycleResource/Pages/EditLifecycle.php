<?php

namespace App\Filament\Resources\LifecycleResource\Pages;

use App\Filament\Resources\LifecycleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLifecycle extends EditRecord
{
    protected static string $resource = LifecycleResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
