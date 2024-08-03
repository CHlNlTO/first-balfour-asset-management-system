<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingAssignments extends BaseWidget
{
    protected static ?string $model = Assignment::class;

    protected function getTableQuery(): Builder
    {
        $pendingStatusId = AssignmentStatus::where('assignment_status', 'Pending')->value('id');
        return Assignment::query()->where('assignment_status', $pendingStatusId);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('employee.id')
                    ->label("Emp ID"),
                Tables\Columns\TextColumn::make('employee.name')
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee_id])),
                Tables\Columns\TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('asset.brand')
                    ->label('Asset')
                    ->getStateUsing(function (Assignment $record): string {
                        $asset = $record->asset;
                        return $asset ? " {$asset->brand} {$asset->model}" : 'N/A';
                    })
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'primary',
                        'In Transfer' => 'warning',
                        'Pending' => 'warning',
                        default => 'gray'
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
