<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareResource\Pages;
use App\Models\Software;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;

class SoftwareResource extends Resource
{
    protected static ?string $model = Software::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('Asset Information')
                    ->schema([
                        Fieldset::make('Asset Details')
                            ->schema([
                                TextInput::make('asset_type')
                                    ->label('Asset Type')
                                    ->default('software')
                                    ->disabled(),
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
                        Fieldset::make('Software Details')
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
                                                return \App\Models\Vendor::pluck('name', 'id');
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
                                                Forms\Components\Textarea::make('vendor.remarks')
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
                    ->createItemButtonLabel('Add Software Asset')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.id')->label('Asset ID')->sortable()->searchable(),
                TextColumn::make('asset.asset_status')->label('Asset Status')->sortable()->searchable(),
                TextColumn::make('asset.brand')->label('Brand')->sortable()->searchable(),
                TextColumn::make('asset.model')->label('Model')->sortable()->searchable(),
                TextColumn::make('version')->sortable()->searchable(),
                TextColumn::make('license_key')->sortable()->searchable(),
                TextColumn::make('license_type')->sortable()->searchable(),
                TextColumn::make('asset.created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('asset.updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSoftware::route('/'),
            'create' => Pages\CreateSoftware::route('/create'),
            'edit' => Pages\EditSoftware::route('/{record}/edit'),
        ];
    }
}
