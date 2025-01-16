<?php

namespace App\Filament\Resources\PCNamesResource\Pages;

use App\Filament\Resources\PCNamesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPCNames extends EditRecord
{
    protected static string $resource = PCNamesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
