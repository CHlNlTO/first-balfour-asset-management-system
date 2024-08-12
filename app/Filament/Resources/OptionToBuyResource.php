<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionToBuyResource\Pages;
use App\Models\OptionToBuy;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionToBuyResource extends Resource
{
    protected static ?string $model = OptionToBuy::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Option to Buy';

    protected static ?string $navigationGroup = 'Manage Transactions';

    protected static ?string $modelLabel = 'Option to Buy';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('assignment_id')
                    ->label('Assignment ID')
                    ->options(Assignment::all()->mapWithKeys(function ($assignment) {
                        return [$assignment->id => $assignment->id . ' - ' . $assignment->employee->first_name . ' ' . $assignment->employee->last_name . ' - ' . $assignment->asset->brand . ' ' . $assignment->asset->model];
                    })->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('asset_cost')
                    ->required()
                    ->prefix('₱')
                    ->numeric()
                    ->label('Asset Cost'),
                Forms\Components\Select::make('option_to_buy_status')
                    ->label('Status')
                    ->options(AssignmentStatus::all()->pluck('assignment_status', 'id'))
                    ->default('10')
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('assignment.id')
                    ->label('Assignment ID')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('employee')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (OptionToBuy $record): string {
                        $employee = $record->assignment->employee->first_name . ' ' . $record->assignment->employee->last_name;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn (OptionToBuy $record): string => route('filament.admin.resources.employees.view', ['record' => $record->assignment->employee->id_num])),
                Tables\Columns\TextColumn::make('asset')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (OptionToBuy $record): string {
                        $asset = $record->assignment->asset->brand . ' ' . $record->assignment->asset->model;
                        return $asset ? $asset : 'N/A';
                    })
                    ->url(fn (OptionToBuy $record): string => route('filament.admin.resources.assets.view', ['record' => $record->assignment->asset_id])),
                Tables\Columns\TextColumn::make('asset_cost')
                    ->money('php')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status.assignment_status')
                    ->label('Status')
                    ->sortable()
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListOptionToBuys::route('/'),
            'create' => Pages\CreateOptionToBuy::route('/create'),
            'view' => Pages\ViewOptionToBuy::route('/{record}'),
            'edit' => Pages\EditOptionToBuy::route('/{record}/edit'),
        ];
    }

}
