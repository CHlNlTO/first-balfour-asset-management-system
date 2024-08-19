<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOptionToBuy extends EditRecord
{
    protected static string $resource = OptionToBuyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
