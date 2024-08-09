<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\CEMREmployee;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = CEMREmployee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Employees';

    protected static ?string $navigationGroup = 'Manage Employees';

    protected static ?string $modelLabel = 'Employees';

    protected static ?int $navigationSort = 1;

    public static function getRouteKeyName(): string
    {
        return 'id_num';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_num')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                    Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->getStateUsing(fn (CEMREmployee $record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('empService.position.name')
                    ->label('Position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('empService.rank.name')
                    ->label('Rank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('empService.project.name')
                    ->label('Project')
                    ->searchable(),
                Tables\Columns\TextColumn::make('empService.division.name')
                    ->label('Division')
                    ->searchable(),
                Tables\Columns\TextColumn::make('empService.status.name')
                    ->label('Employee Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relationships here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'view' => Pages\ViewEmployee::route('/{record}'),
        ];
    }
}
