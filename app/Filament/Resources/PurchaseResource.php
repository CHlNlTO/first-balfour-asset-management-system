<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Models\Purchase;
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
                        TextInput::make('receipt_no')
                            ->required()
                            ->numeric(),
                        DatePicker::make('purchase_date')
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
                    Repeater::make('Asset Information')
                    ->schema([
                        Fieldset::make('Asset Option')
                            ->columns(2)  // Create a two-column layout
                            ->schema([
                                Radio::make('asset_option')
                                    ->label('')
                                    ->options([
                                        'existing' => 'Choose from Existing Assets',
                                        'new' => 'Create New Asset',
                                    ])
                                    ->reactive()
                                    ->default('existing')
                                    ->columnSpan(1), // Set to take up half the width
                                Select::make('asset_id')
                                    ->label('Existing Asset')
                                    ->relationship('asset', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} {$record->brand} {$record->model}")
                                    ->preload()
                                    ->searchable()
                                    ->hidden(fn (callable $get) => $get('asset_option') !== 'existing')
                                    ->required()
                                    ->columnSpan(1), // Set to take up half the width
                            ]),
                        Fieldset::make('Asset Details')
                            ->hidden(fn (callable $get) => $get('asset_option') !== 'new')
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
                            ])
                            ->columns(2),
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
                            ])
                            ->columns(2),
                        Fieldset::make('Software Details')
                            ->hidden(fn (callable $get) => $get('show_software') !== true)
                            ->schema([
                                TextInput::make('version')->label('Version')->required(),
                                TextInput::make('license_key')->label('License Key')->required(),
                                Select::make('license_type')->label('License Type')
                                    ->options([
                                        'one_time'=> 'One-Time',
                                        'monthly_subscription'=> 'Monthly Subscription',
                                        'annual_subscription'=> 'Annual Subscription',
                                        'open_source'=> 'Open Source',
                                        'license_leasing'=> 'License Leasing',
                                        'pay_as_you_go' => 'Pay As You Go',
                                    ])
                                    ->required(),
                            ])
                            ->columns(2),
                        TextInput::make('asset_cost')
                            ->label('Asset Cost')
                            ->required()
                            ->numeric()
                            ->columnSpan(1),  // Set the span to 1 column
                    ])
                    ->columns(2) // Set the repeater to have a two-column layout
                    ->createItemButtonLabel('Add Asset')
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
                TextColumn::make('receipt_no')
                    ->label('Receipt No.')
                    ->sortable(),
                TextColumn::make('purchase_cost')
                    ->label('Asset Cost')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'PHP ' . number_format($state, 2)),
                TextColumn::make('purchase_date')
                    ->label('Purchase Date')
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
                SelectFilter::make('receipt_no')
                    ->label("Filter by Receipt")
                    ->searchable()
                    ->indicator('Receipt No')
                    ->options(Purchase::pluck('receipt_no', 'receipt_no')->toArray()),
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
            // Define any relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
