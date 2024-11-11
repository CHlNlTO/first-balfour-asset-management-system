<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class AssetStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected $listeners = ['departmentFilterUpdated' => '$refresh'];

    public function getStats(): array
    {
        $selectedDepartment = Cache::get('selected_department');

        $query = Asset::query();

        if ($selectedDepartment) {
            $query->where('department_project_code', $selectedDepartment);
        }

        $totalAssets = $query->count();
        $activeAssets = $query->where('asset_status', '1')->count();

        return [
            Stat::make('Total Assets', $totalAssets),
            Stat::make('Active Assets', $activeAssets)->color('success'),
        ];
    }
}
