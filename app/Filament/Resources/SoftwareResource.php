<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareResource\Pages;
use App\Models\AssetStatus;
use App\Models\Software;
use App\Models\LicenseType;
use App\Models\SoftwareType;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Log;

class SoftwareResource extends Resource
{
    protected static ?string $model = Software::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationParentItem = 'Assets';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.asset_status')
                    ->label('Asset Status')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Software $record): string {
                        $assetStatus = AssetStatus::find($record->asset->asset_status);
                        return $assetStatus ? $assetStatus->asset_status : 'N/A';
                    })
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('software_type')
                    ->label('Software Type')
                    ->getStateUsing(function (Software $record): string {
                        $softwareType = SoftwareType::find($record->software_type);
                        return $softwareType ? $softwareType->software_type : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.brand')
                    ->label('Brand')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('asset.model')
                    ->label('Model')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('version')
                    ->label('Version')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),

                TextColumn::make('license_key')
                    ->label('License Key')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A')
                    ->limit(10),
                TextColumn::make('license_type')
                    ->label('License Type')
                    ->getStateUsing(function (Software $record): string {
                        Log::info('License Type ID: ' . $record->license_type);
                        $licenseType = LicenseType::find($record->license_type);
                        Log::info('Found License Type: ' . ($licenseType ? $licenseType->license_type : 'null'));
                        return $licenseType ? $licenseType->license_type : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('pc_name')
                    ->label('PC Name')
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
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('asset_status')
                    ->label('Filter by Asset Status')
                    ->indicator('Asset Status')
                    ->relationship('asset.assetStatus', 'asset_status'),
                SelectFilter::make('software_type')
                    ->label("Filter by Software Type")
                    ->searchable()
                    ->indicator('Software Type')
                    ->options(function () {
                        return SoftwareType::whereNotNull('software_type')
                            ->pluck('software_type', 'id')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
                SelectFilter::make('license_type')
                    ->label("Filter by License Type")
                    ->searchable()
                    ->indicator('License Type')
                    ->options(function () {
                        return LicenseType::whereNotNull('license_type')
                            ->pluck('license_type', 'id')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
                SelectFilter::make('pc_name')
                    ->label('Filter by PC Name')
                    ->searchable()
                    ->indicator('PC Name')
                    ->options(function () {
                        return Software::pluck('pc_name', 'pc_name')->filter(fn($value) => !is_null($value) && $value !== '')->unique()->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (Software $record) => route('filament.admin.resources.assets.edit', ['record' => $record])),
                Tables\Actions\ViewAction::make()
                    ->url(fn (Software $record) => route('filament.admin.resources.assets.view', ['record' => $record])),
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
            'index' => Pages\ListSoftware::route('/'),
            'create' => AssetResource\Pages\CreateAsset::route('/create'),
            'view' => AssetResource\Pages\ViewAsset::route('/{record}'),
            'edit' => AssetResource\Pages\EditAsset::route('/{asset_id}/edit'),
        ];
    }
}
