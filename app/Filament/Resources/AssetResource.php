<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Manage Assets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('assets')
                    ->schema([
                        Fieldset::make('Asset Details')
                            ->schema([
                                Select::make('asset_type')
                                    ->options([
                                        'hardware' => 'Hardware',
                                        'software' => 'Software',
                                    ])
                                    ->required()
                                    ->label('Asset Type')
                                    ->reactive()
                                    ->autofocus()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('show_hardware', $state === 'hardware');
                                        $set('show_software', $state === 'software');
                                    }),
                                Select::make('asset_status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'under repair' => 'Under Repair',
                                        'in transfer' => 'In Transfer',
                                        'disposed' => 'Disposed',
                                        'lost' => 'Lost',
                                        'stolen' => 'Stolen'
                                    ])
                                    ->required()
                                    ->label('Asset Status')
                                    ->default('active'),
                                TextInput::make('brand')->label('Brand')->required(),
                                TextInput::make('model')->label('Model')->required(),
                            ]),
                        Fieldset::make('Hardware Details')
                            ->hidden(fn (callable $get) => $get('show_hardware') !== true)
                            ->schema([
                                TextInput::make('specifications')->label('Specifications')->required(),
                                TextInput::make('serial_number')->label('Serial Number')->required(),
                                TextInput::make('manufacturer')->label('Manufacturer')->required(),
                                DatePicker::make('warranty_expiration')
                                    ->label('Warranty Expiration')
                                    ->displayFormat('m/d/Y')
                                    ->format('Y-m-d')
                                    ->seconds(false),
                            ]),
                        Fieldset::make('Software Details')
                            ->hidden(fn (callable $get) => $get('show_software') !== true)
                            ->schema([
                                TextInput::make('version')->label('Version')->required(),
                                TextInput::make('license_key')->label('License Key')->required(),
                                TextInput::make('license_type')->label('License Type')->required(),
                            ]),
                    ])
                    ->createItemButtonLabel('Add Asset')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

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
                    }),
                TextColumn::make('asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('asset_status')
                    ->label('Asset Status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand')
                    ->label('Brand')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('model')
                    ->label('Model')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('details')
                    ->label('Details')
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('hardware.specifications', 'like', "%{$search}%")
                            ->orWhere('software.version', 'like', "%{$search}%");
                    })
                    ->getStateUsing(fn($record) => $record->details),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.created_at', 'like', "%{$search}%");
                    }),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.updated_at', 'like', "%{$search}%");
                    }),
            ])
            ->filters([
                // Define any filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('assets.id')
            ->modifyQueryUsing(function (Builder $query) {
                $query->leftJoin('hardware', 'assets.id', '=', 'hardware.asset_id')
                    ->leftJoin('software', 'assets.id', '=', 'software.asset_id')
                    ->select('assets.*',
                        'hardware.specifications as hardware_specifications',
                        'software.version as software_version');
            });
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
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
