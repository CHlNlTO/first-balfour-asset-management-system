<?php

namespace App\Filament\App\Widgets;

use App\Filament\App\Resources\AssignmentResource;
use App\Models\Assignment;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class AssignmentsTable extends BaseWidget
{
    protected static ?string $model = Assignment::class;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getTableQuery(): Builder
    {
        $resource = app(AssignmentResource::class);
        return $resource->getEloquentQuery();
    }

    public function table(Table $table): Table
    {
        return app(AssignmentResource::class)
            ->table($table)
            ->query($this->getTableQuery());
    }
}
