<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers\AssetsRelationManager;
use App\Models\AssetStatus;
use App\Models\Purchase;
use App\Models\HardwareType;
use App\Models\SoftwareType;
use App\Models\LicenseType;
use App\Models\PeripheralType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Textarea;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Manage Transactions';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Purchase Information')
                    ->schema([
                        TextInput::make('purchase_order_no')
                            ->label('Purchase Order No.')
                            ->required()
                            ->numeric()
                            ->columnSpan(1),
                        TextInput::make('sales_invoice_no')
                            ->label('Sales Invoice No.')
                            ->required()
                            ->numeric()
                            ->columnSpan(1),
                        DatePicker::make('purchase_order_date')
                            ->label('Purchase Order Date')
                            ->required(),
                    ]),
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
                            ->relationship('vendor', 'name')
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
                                    ->nullable()
                                    ->maxLength(255),
                                TextInput::make('vendor.tel_no_1')
                                    ->label('Telephone No. 1')
                                    ->tel()
                                    ->nullable()
                                    ->maxLength(255),
                                TextInput::make('vendor.tel_no_2')
                                    ->label('Telephone No. 2')
                                    ->nullable()
                                    ->tel()
                                    ->maxLength(255),
                                TextInput::make('vendor.contact_person')
                                    ->label('Contact Person')
                                    ->nullable()
                                    ->maxLength(255),
                                TextInput::make('vendor.mobile_number')
                                    ->label('Mobile Number')
                                    ->nullable()
                                    ->numeric(),
                                TextInput::make('vendor.email')
                                    ->label('Email')
                                    ->email()
                                    ->nullable()
                                    ->maxLength(255),
                                TextInput::make('vendor.url')
                                    ->label('URL')
                                    ->maxLength(255),
                                Textarea::make('vendor.remarks')
                                    ->label('Remarks'),
                            ]),
                    ])
                    ->columnSpanFull(),
                    Repeater::make('Asset Information')
                    ->schema([
                        Fieldset::make('Asset Option')
                            ->columns(2)
                            ->schema([
                                Radio::make('asset_option')
                                    ->label('')
                                    ->options([
                                        'existing' => 'Choose from Existing Assets',
                                        'new' => 'Create New Asset',
                                    ])
                                    ->reactive()
                                    ->default('existing')
                                    ->columnSpan(1),
                                Select::make('asset_id')
                                    ->label('Existing Asset')
                                    ->relationship('asset', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} {$record->brand} {$record->model}")
                                    ->preload()
                                    ->searchable()
                                    ->hidden(fn (callable $get) => $get('asset_option') !== 'existing')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                            Fieldset::make('Asset Details')
                            ->hidden(fn (callable $get) => $get('asset_option') !== 'new')
                            ->schema([
                                Select::make('asset_type')
                                    ->options([
                                        'hardware' => 'Hardware',
                                        'software' => 'Software',
                                        'peripherals' => 'Peripherals',
                                    ])
                                    ->required()
                                    ->label('Asset Type')
                                    ->reactive()
                                    ->autofocus()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('show_hardware', $state === 'hardware');
                                        $set('show_software', $state === 'software');
                                        $set('show_peripherals', $state === 'peripherals');
                                    }),
                                Select::make('asset_status')
                                    ->options(function () {
                                        return AssetStatus::all()->pluck('asset_status', 'id');
                                    })
                                    ->required()
                                    ->reactive()
                                    ->live(),
                                TextInput::make('brand')->label('Brand')->required(),
                                TextInput::make('model')->label('Model')->required(),
                            ]),
                            Fieldset::make('Hardware Details')
                                ->hidden(fn (callable $get) => $get('show_hardware') !== true || $get('asset_option') !== 'new')
                                ->schema([
                                    Select::make('hardware_type')->label('Hardware Type')
                                        ->options(HardwareType::all()->pluck('hardware_type', 'id')->toArray())
                                        ->required(),
                                    TextInput::make('serial_number')->label('Serial No.')->required(),
                                    TextArea::make('specifications')->label('Specifications')->required(),
                                    TextInput::make('manufacturer')->label('Manufacturer')->required(),
                                    DatePicker::make('warranty_expiration')
                                        ->label('Warranty Expiration Date')
                                        ->displayFormat('m/d/Y')
                                        ->format('Y-m-d')
                                        ->seconds(false)
                                        ->nullable(),
                                ]),
                            Fieldset::make('Software Details')
                                ->hidden(fn (callable $get) => $get('show_software') !== true || $get('asset_option') !== 'new')
                                ->schema([
                                    TextInput::make('version')->label('Version')->nullable(),
                                    TextInput::make('license_key')->label('License Key')->nullable(),
                                    Select::make('software_type')->label('Software Type')
                                        ->options(SoftwareType::all()->pluck('software_type', 'id')->toArray())
                                        ->required(),
                                    Select::make('license_type')->label('License Type')
                                        ->options(LicenseType::all()->pluck('license_type', 'id')->toArray())
                                        ->required(),
                                ]),
                            Fieldset::make('Peripherals Details')
                                ->hidden(fn (callable $get) => $get('show_peripherals') !== true || $get('asset_option') !== 'new')
                                ->schema([
                                    Select::make('peripherals_type')->label('Peripheral Type')
                                        ->options(PeripheralType::all()->pluck('peripherals_type', 'id')->toArray())
                                        ->required(),
                                    TextInput::make('serial_number')->label('Serial No.')->required(),
                                    TextArea::make('specifications')->label('Specifications')->required(),
                                    TextInput::make('manufacturer')->label('Manufacturer')->required(),
                                    DatePicker::make('warranty_expiration')
                                        ->label('Warranty Expiration Date')
                                        ->displayFormat('m/d/Y')
                                        ->format('Y-m-d')
                                        ->seconds(false),
                                ]),
                            Fieldset::make('Lifecycle Information')
                                ->hidden(fn (callable $get) => $get('asset_option') !== 'new')
                                ->schema([
                                    DatePicker::make('acquisition_date')
                                        ->label('Acquisition Date')
                                        ->required()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $set('retirement_date', null);
                                        }),
                                    DatePicker::make('retirement_date')
                                        ->label('Retirement Date')
                                        ->nullable()
                                        ->minDate(fn ($get) => $get('acquisition_date'))
                                    ])->reactive(),
                            TextInput::make('purchase_order_amount')
                                ->label('Purchase Order Amount')
                                ->required()
                                ->numeric()
                                ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->addActionLabel('Add Asset')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('asset.brand')
                    ->label('Brand')
                    ->sortable(),
                TextColumn::make('asset.model')
                    ->label('Model')
                    ->sortable(),
                TextColumn::make('purchase_order_no')
                    ->label('Purchase Order No.')
                    ->sortable(),    
                TextColumn::make('sales_invoice_no')
                    ->label('Sales Invoice No.')
                    ->sortable(),
                TextColumn::make('purchase_order_amount')
                    ->label('Purchase Order Amount')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'PHP ' . number_format($state, 2)),
                TextColumn::make('purchase_order_date')
                    ->label('Purchase Order Date')
                    ->sortable()
                    ->date(),
                TextColumn::make('vendor.name')
                    ->label('Vendor ID')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('sales_invoice_no')
                    ->label("Filter by Sales Invoice")
                    ->searchable()
                    ->indicator('Receipt No')
                    ->options(Purchase::pluck('sales_invoice_no', 'sales_invoice_no')->toArray()),
                SelectFilter::make('purchase_order_no')
                    ->label("Filter by Purchase Order")
                    ->searchable()
                    ->indicator('Receipt No')
                    ->options(Purchase::pluck('purchase_order_no', 'purchase_order_no')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('purchases.id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            AssetsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'view' => Pages\ViewPurchase::route('/{record}'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
