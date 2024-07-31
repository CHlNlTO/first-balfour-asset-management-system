<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetStatusesResource\Pages;
use App\Models\AssetStatus;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetStatusesResource extends Resource
{
    protected static ?string $model = AssetStatus::class;

    protected static ?string $navigationGroup = 'Manage Statuses';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('asset_status')
                ->required()
                ->label("Asset Status"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->label('ID')->sortable()->searchable(),
            TextColumn::make('asset_status')->label('Asset Status')->sortable()->searchable(),
            TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: false)->searchable(),
            TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: false)->searchable(),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAssetStatuses::route('/'),
            'create' => Pages\CreateAssetStatuses::route('/create'),
            'edit' => Pages\EditAssetStatuses::route('/{record}/edit'),
        ];
    }
}
