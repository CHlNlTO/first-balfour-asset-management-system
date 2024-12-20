<?php

namespace App\Filament\Resources\AssetResource\Forms;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use App\Models\AssetStatus;
use App\Models\HardwareType;
use Filament\Notifications\Notification;

class CommonFormComponents
{
    public static function getBasicDetailsSection($assetType, $brandPlaceholder, $modelPlaceholder): Section
    {
        return Section::make('Asset Details')
            ->icon('heroicon-o-clipboard-document-list')
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('asset_type')
                            ->required()
                            ->default($assetType)
                            ->disabled()
                            ->inlineLabel(),
                        Select::make('asset_status')
                            ->label('Asset Status')
                            ->options(fn() => AssetStatus::pluck('asset_status', 'id'))
                            ->default(1)
                            ->required()
                            ->createOptionForm([
                                TextInput::make('asset_status')
                                    ->required()
                                    ->placeholder('Active, Inactive'),
                            ])
                            ->createOptionUsing(function ($data) {
                                $assetStatus = AssetStatus::create([
                                    'asset_status' => $data['asset_status']
                                ]);

                                Notification::make()
                                    ->title('Record Created')
                                    ->body("Asset Status {$assetStatus->asset_status} has been created.")
                                    ->success()
                                    ->send();

                                return $assetStatus->id;
                            })
                            ->inlineLabel(),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('brand')
                            ->required()
                            ->placeholder($brandPlaceholder)
                            ->inlineLabel(),
                        TextInput::make('model')
                            ->required()
                            ->placeholder($modelPlaceholder)
                            ->inlineLabel(),
                        TextInput::make('department_project_code')
                            ->label('Dept/Project Code')
                            ->nullable()
                            ->placeholder('IT-2021-001')
                            ->inlineLabel(),
                        TextInput::make('tag_number')
                            ->label('Tag Number')
                            ->nullable()
                            ->placeholder('#A21BQWXGA')
                            ->inlineLabel()
                            ->visible($assetType == 'hardware' || $assetType == 'peripherals'),
                    ]),
            ]);
    }

    public static function getPurchaseSection(): Section
    {
        return Section::make('Purchase Details')
            ->icon('heroicon-o-banknotes')
            ->schema([
                Grid::make(1)
                    ->schema([
                        TextInput::make('purchase_order_no')
                            ->required()
                            ->numeric()
                            ->placeholder('20230001')
                            ->inlineLabel(),
                        TextInput::make('sales_invoice_no')
                            ->required()
                            ->numeric()
                            ->placeholder('74920001')
                            ->inlineLabel(),
                        DatePicker::make('purchase_order_date')
                            ->required()
                            ->default(now())
                            ->inlineLabel(),
                        TextInput::make('purchase_order_amount')
                            ->label('Purchase Cost')
                            ->required()
                            ->numeric()
                            ->placeholder('50000')
                            ->inlineLabel(),
                        TextInput::make('requestor')
                            ->nullable()
                            ->placeholder('John Smith')
                            ->inlineLabel(),
                    ]),
            ]);
    }

    public static function getLifecycleSection(): Section
    {
        return Section::make('Lifecycle Information')
            ->icon('heroicon-o-calendar')
            ->schema([
                Grid::make(1)
                    ->schema([
                        DatePicker::make('acquisition_date')
                            ->required()
                            ->default(now())
                            ->inlineLabel(),
                        DatePicker::make('retirement_date')
                            ->nullable()
                            ->minDate(fn($get) => $get('acquisition_date'))
                            ->default(now()->addYears(5))
                            ->inlineLabel(),
                    ]),
            ]);
    }

    public static function getVendorSection(): Section
    {
        return Section::make('Vendor Information')
            ->icon('heroicon-o-building-office')
            ->schema([
                Select::make('vendor_id')
                    ->label('Vendor')
                    ->options(fn() => \App\Models\Vendor::pluck('name', 'id'))
                    ->required()
                    ->createOptionForm([
                        Section::make('Basic Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Vendor Name')
                                            ->required()
                                            ->placeholder('ABC Computer Solutions')
                                            ->inlineLabel(),
                                        TextInput::make('contact_person')
                                            ->placeholder('John Smith')
                                            ->inlineLabel(),
                                        TextInput::make('email')
                                            ->email()
                                            ->placeholder('contact@abc.com')
                                            ->inlineLabel(),
                                        TextInput::make('url')
                                            ->label('URL')
                                            ->placeholder('www.abccomputers.com')
                                            ->inlineLabel(),
                                    ]),

                            ]),

                        Section::make('Contact Numbers')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('tel_no_1')
                                            ->label('Telephone No. 1')
                                            ->tel()
                                            ->placeholder('(02) 8123-4567')
                                            ->inlineLabel(),
                                        TextInput::make('tel_no_2')
                                            ->label('Telephone No. 2')
                                            ->tel()
                                            ->placeholder('(02) 8765-4321')
                                            ->inlineLabel(),
                                        TextInput::make('mobile_number')
                                            ->numeric()
                                            ->placeholder('09123456789')
                                            ->inlineLabel(),
                                    ]),
                            ]),

                        // Second Column
                        Section::make('Address Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('address_1')
                                            ->label('Address 1')
                                            ->required()
                                            ->placeholder('123 Main Street')
                                            ->inlineLabel(),
                                        TextInput::make('address_2')
                                            ->label('Address 2')
                                            ->placeholder('Floor 2, Suite 205')
                                            ->inlineLabel(),
                                        TextInput::make('city')
                                            ->placeholder('Makati City')
                                            ->inlineLabel(),
                                    ]),

                            ]),
                        Section::make('Additional Information')
                            ->schema([
                                Textarea::make('remarks')
                                    ->placeholder('Preferred vendor for IT equipment')
                                    ->inlineLabel(),
                            ]),
                    ])
                    ->createOptionUsing(function ($data) {
                        $vendor = \App\Models\Vendor::create([
                            'name' => $data['name'],
                            'address_1' => $data['address_1'],
                            'address_2' => $data['address_2'],
                            'city' => $data['city'],
                            'tel_no_1' => $data['tel_no_1'],
                            'tel_no_2' => $data['tel_no_2'],
                            'contact_person' => $data['contact_person'],
                            'mobile_number' => $data['mobile_number'],
                            'email' => $data['email'],
                            'url' => $data['url'],
                            'remarks' => $data['remarks'],
                        ]);

                        Notification::make()
                            ->title('Vendor created successfully')
                            ->success()
                            ->send();

                        return $vendor->id;
                    })
                    ->searchable()
                    ->preload()
                    ->inlineLabel(),
            ]);
    }

    public static function getHardwareTypeSelect(): Select
    {
        return Select::make('hardware_type')
            ->label('Hardware Type')
            ->options(fn() => HardwareType::pluck('hardware_type', 'id'))
            ->required()
            ->createOptionForm([
                TextInput::make('hardware_type')
                    ->required()
                    ->placeholder('Desktop, Laptop, Server'),
            ])
            ->createOptionUsing(function ($data) {
                $hardwareType = HardwareType::create([
                    'hardware_type' => $data['hardware_type']
                ]);

                Notification::make()
                    ->title('Record Created')
                    ->body("Hardware Type {$hardwareType->hardware_type} has been created.")
                    ->success()
                    ->send();

                return $hardwareType->id;
            })
            ->searchable()
            ->live()
            ->afterStateUpdated(fn(callable $set) => $set('hardware_type', 'hardware_type'))
            ->preload()
            ->inlineLabel();
    }
}
