<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeAssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Select::make('employee_id')
                ->label('Employee')
                ->placeholder('Select from registered employees')
                ->relationship('employee', 'id')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} {$record->name}")
                ->preload()
                ->searchable()
                ->required(),
            Forms\Components\Select::make('assignment_status')
                ->label('Assignment Status')
                ->options(AssignmentStatus::all()->pluck('assignment_status', 'id')->toArray())
                ->default('1')
                ->required()
                ->columnSpan(1),
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\DatePicker::make('start_date')
                        ->label('Start Date')
                        ->native()
                        ->closeOnDateSelection()
                        ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('End Date')
                        ->native()
                        ->closeOnDateSelection(),
                ])
                ->columns(2) // Specify two columns for the group
                ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('asset.brand')
                    ->label('Asset')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Assignment $record): string {
                        $asset = $record->asset;
                        if (!$asset) return 'N/A';
                        $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                        $model = $asset->model?->name ?? 'Unknown Model';
                        return "{$brand} {$model}";
                    })
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Assignment Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'primary',
                        'In Transfer' => 'warning',
                        'Pending' => 'warning',
                        'Unknown' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('assignments.id', 'desc');
    }
}
