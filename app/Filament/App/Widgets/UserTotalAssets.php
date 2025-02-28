<?php

namespace App\Filament\App\Widgets;

use App\Models\Assignment;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class UserTotalAssets extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = -4;

    protected int | string | array $columnSpan = 'one-third';

    protected function getColumns(): int
    {
        return 2;
    }

    public function getStats(): array
    {
        // Build a single query with a groupBy to get counts for all statuses at once
        $assignmentCounts = Assignment::where('employee_id', auth()->user()->id_num)
            ->join('assignment_statuses', 'assignments.assignment_status', '=', 'assignment_statuses.id')
            ->select('assignment_statuses.assignment_status', DB::raw('count(*) as count'))
            ->groupBy('assignment_statuses.assignment_status')
            ->pluck('count', 'assignment_statuses.assignment_status')
            ->toArray();

        // Extract the counts we need
        $activeCount = $assignmentCounts['Active'] ?? 0;
        $pendingCount = $assignmentCounts['Pending Approval'] ?? 0;
        $relevantTotal = $activeCount + $pendingCount;
        $totalAssignments = array_sum($assignmentCounts);

        $activeToTotal = "$activeCount / $relevantTotal";

        return [
            Stat::make('Approved Active Assignments', $activeToTotal)
                ->icon('heroicon-o-check-circle')
                ->description("{$pendingCount} pending approval")
                ->descriptionColor('primary')
                ->descriptionIcon('heroicon-o-clock'),
            Stat::make('Total Accumulated Assets', $totalAssignments)
                ->color('success'),
        ];
    }
}
