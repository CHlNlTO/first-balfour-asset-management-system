<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeripheralResource\Pages;
use App\Models\Peripheral;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PeripheralResource extends Resource
{
    protected static ?string $model = Peripheral::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_id')->label('Asset ID')->sortable()->searchable(),
                TextColumn::make('asset.brand')->searchable()->label('Brand'),
                TextColumn::make('asset.model')->searchable()->label('Model'),
                TextColumn::make('specifications')->searchable(),
                TextColumn::make('serial_number')->searchable(),
                TextColumn::make('manufacturer')->searchable(),
                TextColumn::make('warranty_expiration')->date()->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (Peripheral $record) => route('filament.admin.resources.assets.edit', ['record' => $record])),
                Tables\Actions\ViewAction::make()
                    ->url(fn (Peripheral $record) => route('filament.admin.resources.assets.view', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('asset_id', 'desc');
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
            'index' => Pages\ListPeripherals::route('/'),
            'create' => AssetResource\Pages\CreateAsset::route('/create'),
            'view' => AssetResource\Pages\ViewAsset::route('/{record}'),
            'edit' => AssetResource\Pages\EditAsset::route('/{asset_id}/edit'),
        ];
    }
}
