<?php

namespace App\Filament\App\Widgets;

use App\Models\Assignment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserTotalAssets extends BaseWidget
{
    protected static ?int $sort = -4;

    protected int | string | array $columnSpan = 'one-third';

    protected function getColumns(): int
    {
        return 2;
    }

    public function getStats(): array
    {
        $query = Assignment::query()->where('employee_id', auth()->user()->id_num)->with('asset');;
        // $queryCost = Purchase::query()
        //     ->join('assets', 'purchases.asset_id', '=', 'assets.id');

        // $totalCost = $queryCost->sum('purchases.purchase_order_amount');

        $totalAssets = $query->count();

        // Use whereHas to check the related asset's status
        $activeAssets = Assignment::query()
            ->where('employee_id', auth()->user()->id_num)
            ->whereHas('asset', function ($query) {
                $query->where('asset_status', '1');
            })
            ->count();

        $activeToTotal = "$activeAssets / $totalAssets";

        return [
            // Stat::make('Total Assets Cost', '₱' . number_format($totalCost, 2))
            //     ->color('success'),
            Stat::make('Active Assets', $activeToTotal)
                ->color('success'),
            Stat::make('Total Assets', $totalAssets)
                ->color('success'),

        ];
    }
}
