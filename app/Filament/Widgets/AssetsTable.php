<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AssetResource;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Asset;
use App\Models\AssetStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;

class AssetsTable extends BaseWidget
{
    protected static ?string $model = Assignment::class;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        // Get the IDs of the statuses we want to exclude
        $excludedStatusIds = AssignmentStatus::whereIn('assignment_status', [
            'Active',
            'Pending Approval',
            'Pending Return',
            'In Transfer',
            'Transferred'
        ])->pluck('id')->toArray();

        // Current date for comparison
        $currentDate = now();

        return app(AssetResource::class)
            ->table($table)
            ->query(
                Asset::query()
                    ->whereNotIn('assets.id', function ($query) use ($excludedStatusIds, $currentDate) {
                        $query->select('asset_id')
                            ->from('assignments')
                            ->whereIn('assignment_status', $excludedStatusIds)
                            ->where('start_date', '<=', $currentDate)
                            ->where(function ($q) use ($currentDate) {
                                $q->whereNull('end_date')
                                    ->orWhere('end_date', '>=', $currentDate);
                            });
                    })
            );
    }
}
