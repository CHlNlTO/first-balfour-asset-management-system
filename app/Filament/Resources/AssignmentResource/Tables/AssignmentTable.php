<?php

namespace App\Filament\Resources\AssignmentResource\Tables;

use App\Filament\Resources\AssignmentResource\Actions\ApproveSaleAction;
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
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->orWhere('assignments.id', 'like', "%{$search}%");
                }),
            TextColumn::make('asset.id')
                ->label('Asset ID')
                ->sortable()
                ->searchable()
                ->url(fn(Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
            TextColumn::make('asset')
                ->label('Asset Name')
                ->getStateUsing(function (Assignment $record): string {
                    return "{$record->asset->brand} {$record->asset->model}";
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('asset', function (Builder $query) use ($search) {
                        $query->where('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%");
                    });
                })
                ->placeholder('N/A')
                ->url(fn(Assignment $record): string => $record->asset ? route('filament.admin.resources.assets.view', ['record' => $record->asset_id]) : '#'),
            TextColumn::make('employee_id')
                ->label('Employee ID')
                ->sortable()
                ->searchable()
                ->getStateUsing(function (Assignment $record): string {
                    $employee = $record->employee->id_num;
                    return $employee ? $employee : 'N/A';
                })
                ->url(fn(Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num])),
            TextColumn::make('employee')
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
                ->getStateUsing(function (Assignment $record): string {
                    return $record->employee ? "{$record->employee->first_name} {$record->employee->last_name}" : 'N/A';
                })
                ->url(fn(Assignment $record): string => $record->employee ? route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num]) : '#'),
            TextColumn::make('assignment_status')
                ->label('Status')
                ->getStateUsing(function (Assignment $record): string {
                    $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                    return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                })
                ->sortable()
                ->searchable()
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    "Active" => "success",
                    "Pending Approval" => "pending",
                    "Pending Return" => "warning",
                    "In Transfer" => "primary",
                    "Transferred" => "success",
                    "Declined" => "danger",
                    'Unknown' => 'gray',
                    'Asset Sold' => 'success',
                    'Option to Buy' => 'primary',
                    default => 'gray',
                }),
            TextColumn::make('start_date')
                ->label('Start Date')
                ->date()
                ->sortable(),
            TextColumn::make('end_date')
                ->label('End Date')
                ->date()
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
                ApproveSaleAction::make(),
            ])
        ];
    }
}
