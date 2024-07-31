<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HardwareResource\Pages;
use App\Models\Hardware;
use App\Models\HardwareType;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class HardwareResource extends Resource
{
    protected static ?string $model = Hardware::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_id')->label('Asset ID')->sortable()->searchable(),
                TextColumn::make('hardware_type')
                    ->label('Hardware Type')
                    ->getStateUsing(function (Hardware $record): string {
                        $hardwareType = HardwareType::find($record->hardware_type);
                        return $hardwareType ? $hardwareType->hardware_type : 'N/A';
                    })->searchable()->sortable(),
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
                    ->url(fn (Hardware $record) => route('filament.admin.resources.assets.edit', ['record' => $record])),
                Tables\Actions\ViewAction::make()
                    ->url(fn (Hardware $record) => route('filament.admin.resources.assets.view', ['record' => $record])),
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
            'index' => Pages\ListHardware::route('/'),
            'create' => AssetResource\Pages\CreateAsset::route('/create'),
            'view' => AssetResource\Pages\ViewAsset::route('/{record}'),
            'edit' => AssetResource\Pages\EditAsset::route('/{asset_id}/edit'),
        ];
    }
}
