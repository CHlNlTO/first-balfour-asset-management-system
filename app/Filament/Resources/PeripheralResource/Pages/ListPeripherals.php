<?php

namespace App\Filament\Resources\PeripheralResource\Pages;

use App\Filament\Resources\PeripheralResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPeripherals extends ListRecords
{
    protected static string $resource = PeripheralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createPeripherals')
                ->label('Peripherals')
                ->icon('heroicon-m-squares-2x2')
                ->size('lg')
                ->url(route('filament.admin.resources.assets.create-peripherals')),
        ];
    }
}
