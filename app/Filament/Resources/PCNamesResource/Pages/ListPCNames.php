<?php

namespace App\Filament\Resources\PCNamesResource\Pages;

use App\Filament\Resources\PCNamesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPCNames extends ListRecords
{
    protected static string $resource = PCNamesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
