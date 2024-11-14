<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;

class SelectAssetType extends Page
{
    protected static string $resource = AssetResource::class;

    protected static string $view = 'filament.pages.select-asset-type';

    public function getTitle(): string
    {
        return 'Select Asset Type';
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Action::make('createHardware')
    //             ->label('Hardware')
    //             ->icon('heroicon-m-server-stack')
    //             ->size('lg')
    //             ->color('gray')
    //             ->url(route('filament.admin.resources.assets.create-hardware')),

    //         Action::make('createSoftware')
    //             ->label('Software')
    //             ->icon('heroicon-m-cpu-chip')
    //             ->size('lg')
    //             ->color('gray')
    //             ->url(route('filament.admin.resources.assets.create-software')),

    //         Action::make('createPeripherals')
    //             ->label('Peripherals')
    //             ->icon('heroicon-m-squares-2x2')
    //             ->size('lg')
    //             ->color('gray')
    //             ->url(route('filament.admin.resources.assets.create-peripherals')),
    //     ];
    // }
}
