<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use App\Models\AssetStatus;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AssetResource\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\AssetResource\RelationManagers\HardwareRelationManager;
use App\Filament\Resources\AssetResource\RelationManagers\SoftwareRelationmanager;
use Filament\Tables\Filters\SelectFilter;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Asset ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.id', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
                TextColumn::make('tag_number')
                    ->label('Tag Number')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
                TextColumn::make('asset')
                    ->label('Asset Name')
                    ->getStateUsing(fn(Asset $record) => $record->asset)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('model.brand', function ($query) use ($search) {
                            $query->where('brands.name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('model', function ($query) use ($search) {
                                $query->where('models.name', 'like', "%{$search}%");
                            });
                    })
                    ->placeholder('N/A'),
                TextColumn::make('assetStatus.asset_status')
                    ->label('Asset Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn($record) => $record->assetStatus?->color?->getColor())
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('details')
                    ->label('Specifications/Version')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('hardware.specifications', 'like', "%{$search}%")
                            ->orWhere('software.version', 'like', "%{$search}%")
                            ->orWhere('peripherals.specifications', 'like', "%{$search}%");
                    })
                    ->getStateUsing(fn($record) => $record->details)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
                TextColumn::make('costCode.name')
                    ->label('Cost Code')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(true),
                TextColumn::make('costCode.project.name')
                    ->label('Project')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('costCode.project.division.name')
                    ->label('Division')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.created_at', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.updated_at', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
            ])
            ->filters([
                SelectFilter::make('cost_code')
                    ->label("Filter by Cost Code")
                    ->searchable()
                    ->indicator('Cost Code')
                    ->relationship('costCode', 'name')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                'brand',
                'model',
                'costCode.name',
            ])
            ->defaultSort('assets.id', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $query->leftJoin('hardware', 'assets.id', '=', 'hardware.asset_id')
                    ->leftJoin('software', 'assets.id', '=', 'software.asset_id')
                    ->leftJoin('peripherals', 'assets.id', '=', 'peripherals.asset_id')
                    ->select(
                        'assets.*',
                        'hardware.specifications as hardware_specifications',
                        'software.version as software_version',
                        'peripherals.specifications as peripherals_specifications',
                    );
            });
    }

    public static function getRelations(): array
    {
        return [
            AssignmentsRelationManager::class,
            // SoftwareRelationmanager::class,
            // HardwareRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\SelectAssetType::route('/create'),
            'create-hardware' => Pages\CreateHardwareAsset::route('/create-hardware'),
            'create-software' => Pages\CreateSoftwareAsset::route('/create-software'),
            'create-peripherals' => Pages\CreatePeripheralsAsset::route('/create-peripherals'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
