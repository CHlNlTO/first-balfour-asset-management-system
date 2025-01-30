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

class AssetsTable extends BaseWidget
{
    protected static ?string $model = Assignment::class;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return app(AssetResource::class)
            ->table($table)
            ->query(Asset::query());
    }
}
