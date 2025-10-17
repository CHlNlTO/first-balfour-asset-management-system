<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeripheralResource\Pages;
use App\Models\Peripheral;
use App\Models\PeripheralType;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class PeripheralResource extends Resource
{
    protected static ?string $model = Peripheral::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.assetStatus.asset_status')
                    ->label('Asset Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn($record) => $record->asset->assetStatus?->color?->getColor())
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('peripherals_type')
                    ->label('Peripherals Type')
                    ->getStateUsing(function (Peripheral $record): string {
                        $peripheralsType = PeripheralType::find($record->peripherals_type);
                        return $peripheralsType ? $peripheralsType->peripherals_type : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.model.brand.name')
                    ->label('Brand')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.model.name')
                    ->label('Model')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('specifications')
                    ->label('Specifications')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->limit(20)
                    ->placeholder('N/A'),
                TextColumn::make('serial_number')
                    ->label('Serial Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('manufacturer')
                    ->label('Manufacturer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->limit(20)
                    ->placeholder('N/A'),
                TextColumn::make('warranty_expiration')
                    ->label('Warranty Expiration')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
            ])
            ->filters([
                SelectFilter::make('peripherals_type')
                    ->label('Filter by Peripherals Type')
                    ->searchable()
                    ->indicator('Peripherals Type')
                    ->options(function () {
                        return PeripheralType::whereNotNull('peripherals_type')
                            ->pluck('peripherals_type', 'id')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
                SelectFilter::make('peripherals_type')
                    ->label("Filter by Peripherals Type")
                    ->searchable()
                    ->indicator('Peripherals Type')
                    ->options(function () {
                        return PeripheralType::whereNotNull('peripherals_type')
                            ->pluck('peripherals_type', 'id')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn(Peripheral $record) => route('filament.admin.resources.assets.edit', ['record' => $record])),
                Tables\Actions\ViewAction::make()
                    ->url(fn(Peripheral $record) => route('filament.admin.resources.assets.view', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('asset_id', 'desc');
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
