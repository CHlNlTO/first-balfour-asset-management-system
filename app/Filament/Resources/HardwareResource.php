<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HardwareResource\Pages;
use App\Models\Hardware;
use App\Models\Vendor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;

class HardwareResource extends Resource
{
    protected static ?string $model = Hardware::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('assets')
                    ->schema([
                        Fieldset::make('Asset Details')
                            ->schema([
                                TextInput::make('asset_type')
                                    ->label('Asset Type')
                                    ->default('hardware')
                                    ->disabled(),
                                Select::make('asset_status')
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
                                TextInput::make('brand')->label('Brand')->required(),
                                TextInput::make('model')->label('Model')->required(),
                            ]),
                        Fieldset::make('Hardware Details')
                            ->schema([
                                TextInput::make('specifications')->label('Specifications')->required(),
                                TextInput::make('serial_number')->label('Serial Number')->required(),
                                TextInput::make('manufacturer')->label('Manufacturer')->required(),
                                DatePicker::make('warranty_expiration')
                                    ->label('Warranty Expiration')
                                    ->prefixIcon('heroicon-o-calendar')
                                    ->seconds(false)
                                    ->closeOnDateSelection()
                                    ->displayFormat('m-d-y')
                                    ->format('Y-m-d'),
                            ]),
                        Radio::make('add_purchase_information')
                            ->label('Add Purchase Information?')
                            ->options([
                                'yes' => 'Yes',
                                'no' => 'No',
                            ])
                            ->default('no')
                            ->reactive(),
                        Fieldset::make('Purchase Information')
                            ->hidden(fn (callable $get) => $get('add_purchase_information') !== 'yes')
                            ->schema([
                                TextInput::make('receipt_no')
                                    ->label('Receipt No.')
                                    ->required()
                                    ->numeric(),
                                DatePicker::make('purchase_date')
                                    ->label('Purchase Date')
                                    ->required(),
                                Fieldset::make('Vendor Information')
                                    ->schema([
                                        Radio::make('vendor_option')
                                            ->label('Vendor Option')
                                            ->options([
                                                'existing' => 'Choose from Existing Vendors',
                                                'new' => 'Create New Vendor',
                                            ])
                                            ->reactive()
                                            ->default('existing'),
                                        Select::make('vendor_id')
                                            ->label('Existing Vendor')
                                            ->options(function () {
                                                return Vendor::pluck('name', 'id');
                                            })
                                            ->preload()
                                            ->searchable()
                                            ->hidden(fn (callable $get) => $get('vendor_option') !== 'existing')
                                            ->required(),
                                        Fieldset::make('New Vendor Details')
                                            ->hidden(fn (callable $get) => $get('vendor_option') !== 'new')
                                            ->schema([
                                                TextInput::make('vendor.name')
                                                    ->label('Vendor Name')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.address_1')
                                                    ->label('Address 1')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.address_2')
                                                    ->label('Address 2')
                                                    ->maxLength(255),
                                                TextInput::make('vendor.city')
                                                    ->label('City')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.tel_no_1')
                                                    ->label('Telephone No. 1')
                                                    ->tel()
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.tel_no_2')
                                                    ->label('Telephone No. 2')
                                                    ->tel()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.contact_person')
                                                    ->label('Contact Person')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.mobile_number')
                                                    ->label('Mobile Number')
                                                    ->required()
                                                    ->numeric(),
                                                TextInput::make('vendor.email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('vendor.url')
                                                    ->label('URL')
                                                    ->maxLength(255),
                                                Textarea::make('vendor.remarks')
                                                    ->label('Remarks'),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                                TextInput::make('asset_cost')
                                    ->label('Asset Cost')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1),
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
                TextColumn::make('warranty_expiration')->date()->sortable()->searchable(),
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
