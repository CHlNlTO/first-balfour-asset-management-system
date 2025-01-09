<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingReturns extends BaseWidget
{
    protected static ?string $model = Assignment::class;

    protected int | string | array $columnSpan = 'half';

    protected static ?string $heading = 'Assets To Return by Employees';

    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder
    {
        $pendingStatusId = AssignmentStatus::where('assignment_status', 'Pending Return')->value('id');
        return Assignment::query()->where('assignment_status', $pendingStatusId);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('employee.id_num')
                    ->label("Emp ID")
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num])),
                Tables\Columns\TextColumn::make('employee')
                    ->label('Employee')
                    ->getStateUsing(function (Assignment $record): string {
                        return "{$record->employee->first_name} {$record->employee->last_name}";
                    })
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num])),
                Tables\Columns\TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('asset.brand')
                    ->label('Asset')
                    ->getStateUsing(function (Assignment $record): string {
                        $asset = $record->asset;
                        return $asset ? " {$asset->brand} {$asset->model}" : 'N/A';
                    })
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        "Active" => "success",
                        "Pending Approval" => "pending",
                        "Pending Return" => "warning",
                        "In Transfer" => "primary",
                        "Transferred" => "success",
                        "Declined" => "danger",
                        'Unknown' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->actions([
                // Add any actions if needed
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultSort('id', 'desc');
    }
}
