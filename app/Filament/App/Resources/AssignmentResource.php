<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
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
                    return $asset ? " {$asset->brand} {$asset->model}" : 'N/A';
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
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignments::route('/'),
            'view' => Pages\ViewAssignment::route('/{record}'),
        ];
    }
}
