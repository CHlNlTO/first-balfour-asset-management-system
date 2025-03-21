<?php

namespace App\Filament\Resources\AssignmentResource\Tables;

use App\Filament\Resources\Actions\ApproveSaleAction;
use App\Filament\Resources\AssignmentResource\Actions\ManageTransferAction;
use App\Filament\Resources\AssignmentResource\Actions\OptionToBuyAction;
use App\Filament\Resources\AssignmentResource\Actions\TransferAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AssignmentTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns(static::getColumns())
            ->filters(static::getFilters())
            ->actions(static::getActions())
            ->bulkActions(static::getBulkActions())
            ->defaultSort('id', 'desc');
    }

    protected static function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            TextColumn::make('asset.id')
                ->label('Asset ID')
                ->sortable()
                ->searchable()
                ->url(fn(Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
            TextColumn::make('asset.tag_number')
                ->label('Tag Number')
                ->sortable()
                ->searchable()
                ->url(fn(Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
            TextColumn::make('asset.asset')
                ->label('Asset Name')
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->orWhereHas('asset.model.brand', function ($query) use ($search) {
                        $query->where('brands.name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('asset.model', function ($query) use ($search) {
                            $query->where('models.name', 'like', "%{$search}%");
                        });
                })
                ->placeholder('N/A')
                ->url(fn(Assignment $record): string => $record->asset ? route('filament.admin.resources.assets.view', ['record' => $record->asset_id]) : '#'),
            TextColumn::make('employee_id')
                ->label('Employee ID')
                ->sortable()
                ->searchable()
                ->getStateUsing(function (Assignment $record): string {
                    // Add null check
                    return $record->employee?->id_num ?? 'N/A';
                })
                ->url(function (Assignment $record): ?string {
                    // Only generate URL if employee exists
                    if (!$record->employee) return null;
                    return route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num]);
                }),
            TextColumn::make('employee.fullName')
                ->label('Employee Name')
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereExists(function ($query) use ($search) {
                        $query->select(DB::raw(1))
                            ->from('central_employeedb.employees')
                            ->whereColumn('assignments.employee_id', 'central_employeedb.employees.id_num')
                            ->where(function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                    });
                })
                ->url(fn(Assignment $record): string => $record->employee ? route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num]) : '#'),
            TextColumn::make('status.assignment_status')
                ->label('Assignment Status')
                ->sortable()
                ->searchable()
                ->badge()
                ->color(fn($record) => $record->status?->color?->getColor())
                ->copyable()
                ->copyMessage('Copied!')
                ->tooltip('Click to copy')
                ->placeholder('N/A'),
            TextColumn::make('start_date')
                ->label('Start Date')
                ->date()
                ->placeholder('N/A')
                ->sortable(),
            TextColumn::make('end_date')
                ->label('End Date')
                ->date()
                ->placeholder('N/A')
                ->sortable(),
            TextColumn::make('remarks')
                ->label('Remarks')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->placeholder('No remarks'),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected static function getFilters(): array
    {
        return [
            SelectFilter::make('assignment_status')
                ->label("Filter by Assignment Status")
                ->searchable()
                ->indicator('Status')
                ->options(AssignmentStatus::pluck('assignment_status', 'id')->toArray()),
            SelectFilter::make('employee_id')
                ->label("Filter by Employee Name")
                ->searchable()
                ->indicator('Employee')
                ->options(
                    CEMREmployee::on('central_employeedb')
                        ->get()
                        ->mapWithKeys(function ($employee) {
                            $fullName = trim("{$employee->first_name} {$employee->last_name}");
                            return [$employee->id_num => $fullName];
                        })
                        ->toArray()
                ),
        ];
    }

    protected static function getBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    protected static function getActions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                TransferAction::make(),
                ManageTransferAction::make(),
                OptionToBuyAction::make(),
                ApproveSaleAction::makeForAssignment(),
            ])
        ];
    }
}
