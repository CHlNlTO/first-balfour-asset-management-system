<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use App\Models\AssetStatus;
use App\Models\Software;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hardware;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class HardwareRelationManager extends RelationManager
{
    protected static string $relationship = 'installedHardware';

    protected static ?string $title = 'Installed On Hardware';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->asset_type === 'software';
    }

    public function table(Table $table): Table
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
                TextColumn::make('asset.model.brand.name')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('asset.model.name')
                    ->label('Model')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('asset.asset_status')
                    ->label('Asset Status')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Hardware $record): string {
                        $assetStatus = AssetStatus::find($record->asset->asset_status);
                        return $assetStatus ? $assetStatus->asset_status : 'N/A';
                    })
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('hardware_type')
                    ->label('Hardware Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('serial_number')
                    ->label('Serial Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('manufacturer')
                    ->label('Manufacturer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pc_name')
                    ->label('PC Name')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('mac_address')
                    ->label('MAC Address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('warranty_expiration')
                    ->label('Warranty Expiration')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
    }
}
