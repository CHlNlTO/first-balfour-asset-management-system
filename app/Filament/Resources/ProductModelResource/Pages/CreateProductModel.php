<?php

namespace App\Filament\Resources\ProductModelResource\Pages;

use App\Filament\Resources\ProductModelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductModel extends CreateRecord
{
    protected static string $resource = ProductModelResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
