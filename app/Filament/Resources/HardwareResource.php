<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HardwareResource\Pages;
use App\Models\Hardware;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Repeater;

class HardwareResource extends Resource
{
    protected static ?string $model = Hardware::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'Manage Assets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('assets')
                    ->schema([
                        Forms\Components\Fieldset::make('Asset Details')
                            ->schema([
                                Forms\Components\TextInput::make('asset_type')
                                    ->label('Asset Type')
                                    ->default('hardware')
                                    ->disabled(),
                                Forms\Components\Select::make('asset_status')
                                    ->label('Asset Status')
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
                                    ->autofocus()
                                    ->default('active'),
                                Forms\Components\TextInput::make('brand')->label('Brand')->required(),
                                Forms\Components\TextInput::make('model')->label('Model')->required(),
                            ]),
                        Forms\Components\Fieldset::make('Hardware Details')
                            ->schema([
                                Forms\Components\TextInput::make('specifications')->label('Specifications')->required(),
                                Forms\Components\TextInput::make('serial_number')->label('Serial Number')->required(),
                                Forms\Components\TextInput::make('manufacturer')->label('Manufacturer')->required(),
                                Forms\Components\DatePicker::make('warranty_expiration')
                                    ->label('Warranty Expiration')
                                    ->prefixIcon('heroicon-o-calendar')
                                    ->seconds(false)
                                    ->closeOnDateSelection()
                                    ->displayFormat('m-d-y')
                                    ->format('Y-m-d'),
                            ]),
                    ])
                    ->createItemButtonLabel('Add Hardware Asset')
                    ->columnSpanFull()
                    ->required(),
            ])
            ->columns(2);
    }

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
                TextColumn::make('warranty_expiration')->dateTime()->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHardware::route('/'),
            'create' => Pages\CreateHardware::route('/create'),
            'edit' => Pages\EditHardware::route('/{record}/edit'),
        ];
    }
}
