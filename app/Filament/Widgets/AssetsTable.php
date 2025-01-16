<?php

namespace App\Filament\Widgets;

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

    // protected function getTableQuery(): Builder
    // {
    //     $pendingStatusId = AssignmentStatus::where('assignment_status', 'Pending Approval')->value('id');
    //     return Assignment::query()->where('assignment_status', $pendingStatusId);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->query(Asset::query())
            ->columns([
                TextColumn::make('id')
                    ->label('Asset ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.id', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
                TextColumn::make('asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('asset_status')
                    ->label('Asset Status')
                    ->getStateUsing(function (Asset $record): string {
                        $assetStatus = AssetStatus::find($record->asset_status);
                        return $assetStatus ? $assetStatus->asset_status : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'gray',
                        'In Transfer' => 'primary',
                        'Maintenance' => 'warning',
                        'Lost' => 'gray',
                        'Disposed' => 'gray',
                        'Stolen' => 'danger',
                        'Unknown' => 'gray',
                        'Sold' => 'success',
                        default => 'gray',
                    })
                    ->placeholder('N/A'),
                TextColumn::make('asset')
                    ->label('Asset Name')
                    ->getStateUsing(fn(Asset $record) => $record->asset)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('model.brand', function ($query) use ($search) {
                            $query->where('brands.name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('model', function ($query) use ($search) {
                                $query->where('models.name', 'like', "%{$search}%");
                            });
                    })
                    ->placeholder('N/A'),
                TextColumn::make('details')
                    ->label('Specifications/Version')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('hardware.specifications', 'like', "%{$search}%")
                            ->orWhere('software.version', 'like', "%{$search}%")
                            ->orWhere('peripherals.specifications', 'like', "%{$search}%");
                    })
                    ->getStateUsing(fn($record) => $record->details)
                    ->placeholder('N/A'),
                TextColumn::make('department_project_code')
                    ->label('Department/Project Code')
                    ->getStateUsing(function (Asset $record): string {
                        return "{$record->department_project_code}";
                    })
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.created_at', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.updated_at', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
            ])
            ->filters([
                SelectFilter::make('department_project_code')
                    ->label("Filter by Department/Project Code")
                    ->searchable()
                    ->indicator('Status')
                    ->options(function () {
                        return Asset::whereNotNull('department_project_code')
                            ->pluck('department_project_code', 'department_project_code')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                'asset_type',
                'asset_status',
                'department_project_code',
                'brand',
                'model',
            ])
            ->defaultSort('assets.id', 'desc')
            ->defaultPaginationPageOption(5)
            ->modifyQueryUsing(function (Builder $query) {
                $query->leftJoin('hardware', 'assets.id', '=', 'hardware.asset_id')
                    ->leftJoin('software', 'assets.id', '=', 'software.asset_id')
                    ->leftJoin('peripherals', 'assets.id', '=', 'peripherals.asset_id')
                    ->select(
                        'assets.*',
                        'hardware.specifications as hardware_specifications',
                        'software.version as software_version',
                        'peripherals.specifications as peripherals_specifications',
                    );
            });
    }
}
