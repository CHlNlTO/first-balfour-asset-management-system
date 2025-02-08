<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HardwareResource\Pages;
use App\Models\Asset;
use App\Models\AssetStatus;
use App\Models\Hardware;
use App\Models\HardwareType;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Log;

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
                TextColumn::make('asset_id')->label('Asset ID')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('id')->label('Hardware ID')
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
                TextColumn::make('hardware_type')
                    ->label('Hardware Type')
                    ->getStateUsing(function (Hardware $record): string {
                        $hardwareType = HardwareType::find($record->hardware_type);
                        return $hardwareType ? $hardwareType->hardware_type : 'N/A';
                    })
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.model.brand.name')
                    ->searchable()
                    ->sortable()
                    ->label('Brand')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.model.name')
                    ->searchable()
                    ->sortable()
                    ->label('Model')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('specifications')
                    ->searchable()
                    ->sortable()
                    ->label('Specifications')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->limit(20)
                    ->placeholder('N/A'),
                TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->label('Serial Number')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('manufacturer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Manufacturer')
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->limit(20)
                    ->placeholder('N/A'),
                TextColumn::make('mac_address')
                    ->searchable()
                    ->sortable()
                    ->label('MAC Address')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->limit(20)
                    ->placeholder('N/A'),
                TextColumn::make('accessories')
                    ->searchable()
                    ->sortable()
                    ->label('Accessories')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->limit(20)
                    ->placeholder('N/A'),
                TextColumn::make('pcName.name')
                    ->searchable()
                    ->sortable()
                    ->label('PC Name')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('warranty_expiration')
                    ->sortable()
                    ->searchable()
                    ->label('Warranty Expiration')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('updated_at')
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
                SelectFilter::make('asset_status')
                    ->label('Filter by Asset Status')
                    ->indicator('Asset Status')
                    ->relationship('asset.assetStatus', 'asset_status'),
                SelectFilter::make('hardware_type')
                    ->label("Filter by Hardware Type")
                    ->searchable()
                    ->indicator('Hardware Type')
                    ->options(function () {
                        return HardwareType::whereNotNull('hardware_type')
                            ->pluck('hardware_type', 'id')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
                SelectFilter::make('pcName.name')
                    ->label('Filter by PC Name')
                    ->searchable()
                    ->indicator('PC Name')
                    ->relationship('pcName', 'name')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn(Hardware $record) => route('filament.admin.resources.assets.edit', ['record' => $record])),
                Tables\Actions\ViewAction::make()
                    ->url(fn(Hardware $record) => route('filament.admin.resources.assets.view', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('asset_id', 'desc');
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
