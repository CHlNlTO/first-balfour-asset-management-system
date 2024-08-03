<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\AssetStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssetStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Assets', Asset::count()),
            Stat::make('Active Assets', Asset::where('asset_status', '1')->count())->color('success'),
            Stat::make('Inactive Assets', Asset::where('asset_status', '2')->count()),
        ];
    }
}
