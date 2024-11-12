<?php

namespace App\Filament\Resources\SoftwareResource\Pages;

use App\Filament\Resources\SoftwareResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListSoftware extends ListRecords
{
    protected static string $resource = SoftwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createSoftware')
                ->label('Software')
                ->icon('heroicon-m-cpu-chip')
                ->size('lg')
                ->url(route('filament.admin.resources.assets.create-software')),
        ];
    }
}
