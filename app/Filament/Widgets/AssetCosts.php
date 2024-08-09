<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Purchase;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssetCosts extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getCards(): array
    {
        // Current date
        $now = Carbon::now();

        // Start of the current month, quarter, and year
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfQuarter = $now->copy()->firstOfQuarter();
        $startOfYear = $now->copy()->startOfYear();

        // Calculate asset costs for each period
        $monthlyCost = $this->calculateCost($startOfMonth, $now);
        $quarterlyCost = $this->calculateCost($startOfQuarter, $now);
        $yearlyCost = $this->calculateCost($startOfYear, $now);

        // Calculate costs for the previous periods for comparison
        $previousMonthlyCost = $this->calculateCost($startOfMonth->copy()->subMonth(), $startOfMonth);
        $previousQuarterlyCost = $this->calculateCost($startOfQuarter->copy()->subQuarter(), $startOfQuarter);
        $previousYearlyCost = $this->calculateCost($startOfYear->copy()->subYear(), $startOfYear);

        // Calculate trends
        $monthlyTrend = $this->calculateTrend($monthlyCost, $previousMonthlyCost);
        $quarterlyTrend = $this->calculateTrend($quarterlyCost, $previousQuarterlyCost);
        $yearlyTrend = $this->calculateTrend($yearlyCost, $previousYearlyCost);

        return [
            Stat::make('Monthly Asset Cost', '₱' . number_format($monthlyCost, 2))
                ->description($this->formatDescription($monthlyTrend))
                ->descriptionIcon($this->getTrendIcon($monthlyTrend))
                ->chart($this->generateMonthlyChart())
                ->color($this->formatColor($monthlyTrend)),

            Stat::make('Quarterly Asset Cost', '₱' . number_format($quarterlyCost, 2))
                ->description($this->formatDescription($quarterlyTrend))
                ->descriptionIcon($this->getTrendIcon($quarterlyTrend))
                ->chart($this->generateQuarterlyChart())
                ->color($this->formatColor($quarterlyTrend)),

            Stat::make('Yearly Asset Cost', '₱' . number_format($yearlyCost, 2))
                ->description($this->formatDescription($yearlyTrend))
                ->descriptionIcon($this->getTrendIcon($yearlyTrend))
                ->chart($this->generateYearlyChart())
                ->color($this->formatColor($yearlyTrend)),
        ];
    }

    protected function calculateCost(Carbon $startDate, Carbon $endDate): float
    {
        // Replace `purchase_date` and `cost` with your actual column names
        return Purchase::whereBetween('purchase_order_date', [$startDate, $endDate])
            ->sum('purchase_order_amount');
    }

    protected function calculateTrend(float $currentCost, float $previousCost): float
    {
        if ($previousCost == 0) {
            return $currentCost > 0 ? 100 : 0;
        }
        return (($currentCost - $previousCost) / $previousCost) * 100;
    }

    protected function formatDescription(float $trend): string
    {
        $trendText = number_format(abs($trend), 2) . '%';
        return $trend >= 0 ? "$trendText increase" : "$trendText decrease";
    }

    protected function formatColor(float $trend): string
    {
        $trendText = number_format(abs($trend), 2) . '%';
        return $trend >= 0 ? "success" : "danger";
    }

    protected function getTrendIcon(float $trend): string
    {
        return $trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }

    protected function generateMonthlyChart(): array
    {
        // Generate data points for the monthly chart
        $points = [];
        for ($i = 0; $i < 12; $i++) {
            $start = Carbon::now()->subMonths($i + 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $points[] = $this->calculateCost($start, $end);
        }
        return array_reverse($points);
    }

    protected function generateQuarterlyChart(): array
    {
        // Generate data points for the quarterly chart
        $points = [];
        for ($i = 0; $i < 4; $i++) {
            $start = Carbon::now()->subQuarters($i + 1)->firstOfQuarter();
            $end = $start->copy()->endOfQuarter();
            $points[] = $this->calculateCost($start, $end);
        }
        return array_reverse($points);
    }

    protected function generateYearlyChart(): array
    {
        // Generate data points for the yearly chart
        $points = [];
        for ($i = 0; $i < 5; $i++) {
            $start = Carbon::now()->subYears($i + 1)->startOfYear();
            $end = $start->copy()->endOfYear();
            $points[] = $this->calculateCost($start, $end);
        }
        return array_reverse($points);
    }
}
