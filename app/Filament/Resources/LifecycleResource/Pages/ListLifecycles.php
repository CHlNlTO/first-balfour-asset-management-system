<?php

namespace App\Filament\Resources\LifecycleResource\Pages;

use App\Filament\Resources\LifecycleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLifecycles extends ListRecords
{
    protected static string $resource = LifecycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
