<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Purchase;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AssetCosts extends BaseWidget
{
    protected static ?int $sort = 3;

    protected $listeners = ['departmentFilterUpdated' => '$refresh'];

    public function getStats(): array
    {
        $selectedDepartment = Cache::get('selected_department');

        $query = Purchase::query()
            ->join('assets', 'purchases.asset_id', '=', 'assets.id');

        if ($selectedDepartment) {
            $query->where('assets.department_project_code', $selectedDepartment);
        }

        $totalCost = $query->sum('purchases.purchase_order_amount');

        return [
            Stat::make('Total Asset Cost', '₱' . number_format($totalCost, 2))
                ->description('Total cost of assets')
                ->color('success'),
        ];
    }
}
