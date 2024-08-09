<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareResource\Pages;
use App\Models\Software;
use App\Models\LicenseType;
use App\Models\SoftwareType;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
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
                TextColumn::make('asset.id')->label('Asset ID')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('asset.asset_status')->label('Asset Status')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('asset.brand')->label('Brand')->sortable()->searchable(),
                TextColumn::make('asset.model')->label('Model')->sortable()->searchable(),
                TextColumn::make('version')->sortable()->searchable(),
                TextColumn::make('license_key')->sortable()->searchable(),
                TextColumn::make('license_type')
                    ->label('License Type')
                    ->getStateUsing(function (Software $record): string {
                        Log::info('License Type ID: ' . $record->license_type);
                        $licenseType = LicenseType::find($record->license_type);
                        Log::info('Found License Type: ' . ($licenseType ? $licenseType->license_type : 'null'));
                        return $licenseType ? $licenseType->license_type : 'N/A';
                    }),
                TextColumn::make('software_type')
                    ->label('Software Type')
                    ->getStateUsing(function (Software $record): string {
                        Log::info('Software Type ID: ' . $record->software_type);
                        $softwareType = SoftwareType::find($record->software_type);
                        Log::info('Found Software Type: ' . ($softwareType ? $softwareType->software_type : 'null'));
                        return $softwareType ? $softwareType->software_type : 'N/A';
                    }),
                TextColumn::make('asset.created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('asset.updated_at')->label('Updated At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
