<?php

namespace App\Filament\Resources\LifecycleResource\Pages;

use App\Filament\Resources\LifecycleResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListLifecycles extends ListRecords
{
    protected static string $resource = LifecycleResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Assets'),
            'hardware' => Tab::make('Hardware')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('asset', fn($query) => $query->where('asset_type', 'hardware'))),
            'software' => Tab::make('Software')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('asset', fn($query) => $query->where('asset_type', 'software'))),
            'peripherals' => Tab::make('Peripherals')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('asset', fn($query) => $query->where('asset_type', 'peripherals'))),
        ];
    }
}
