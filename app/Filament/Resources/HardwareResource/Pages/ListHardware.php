<?php

namespace App\Filament\Resources\HardwareResource\Pages;

use App\Filament\Resources\HardwareResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListHardware extends ListRecords
{
    protected static string $resource = HardwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createHardware')
                ->label('Hardware')
                ->icon('heroicon-m-server-stack')
                ->size('lg')
                ->url(route('filament.admin.resources.assets.create-hardware')),
        ];
    }
}
