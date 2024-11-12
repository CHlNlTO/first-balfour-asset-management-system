<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Purchase;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class AssetStatsOverview extends BaseWidget
{
    protected static ?int $sort = -4;

    protected int | string | array $columnSpan = 'one-third';

    protected function getColumns(): int
    {
        return 2;
    }

    public function getStats(): array
    {
        $query = Asset::query();
        $queryCost = Purchase::query()
            ->join('assets', 'purchases.asset_id', '=', 'assets.id');

        $totalCost = $queryCost->sum('purchases.purchase_order_amount');

        $totalAssets = $query->count();
        $activeAssets = $query->where('asset_status', '1')->count();

        $activeToTotal = "$activeAssets / $totalAssets";

        return [
            Stat::make('Total Assets Cost', '₱' . number_format($totalCost, 2))
                ->color('success'),
            Stat::make('Active Assets', $activeToTotal)
                ->color('success'),
        ];
    }
}
