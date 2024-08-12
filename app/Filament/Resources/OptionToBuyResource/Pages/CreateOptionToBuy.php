<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOptionToBuy extends CreateRecord
{
    protected static string $resource = OptionToBuyResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
