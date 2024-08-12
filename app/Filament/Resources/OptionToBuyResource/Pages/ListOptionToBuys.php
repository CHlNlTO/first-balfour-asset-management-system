<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOptionToBuys extends ListRecords
{
    protected static string $resource = OptionToBuyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
