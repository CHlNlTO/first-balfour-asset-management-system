<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LifecycleResource\Pages;
use App\Models\Lifecycle;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LifecycleResource extends Resource
{
    protected static ?string $model = Lifecycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('acquisition_date')
                    ->label('Acquisition Date')
                    ->displayFormat('m/d/Y')
                    ->required(),
                Forms\Components\DatePicker::make('retirement_date')
                    ->label('Acquisition Date')
                    ->displayFormat('m/d/Y')
                    ->default(now()->addYears(5))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('asset.brand')
                    ->label('Asset Brand')
                    ->sortable(),
                TextColumn::make('acquisition_date')
                    ->label('Start Date')
                    ->date('m-d-Y')
                    ->sortable(),
                TextColumn::make('retirement_date')
                    ->label('Retirement Date')
                    ->date('m-d-Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('m-d-Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('m-d-Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLifecycles::route('/'),
            'create' => Pages\CreateLifecycle::route('/create'),
            'edit' => Pages\EditLifecycle::route('/{record}/edit'),
        ];
    }
}
