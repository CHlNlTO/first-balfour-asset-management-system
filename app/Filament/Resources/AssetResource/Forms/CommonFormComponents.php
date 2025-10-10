<?php

namespace App\Filament\Resources\AssetResource\Forms;

use App\Filament\Resources\CostCodeResource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use App\Models\AssetStatus;
use App\Models\Brand;
use App\Models\CostCode;
use App\Models\Project;
use App\Models\Division;
use App\Models\HardwareType;
use App\Models\ProductModel;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class CommonFormComponents
{
    public static function getBasicDetailsSection($assetType, $brandPlaceholder, $modelPlaceholder): Section
    {
        // For software, use a simpler brand-only workflow
        if ($assetType === 'software') {
            return static::getSoftwareBrandSection($brandPlaceholder);
        }

        // For hardware and peripherals, use the standard brand+model workflow
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
                            ->createOptionForm([
                                TextInput::make('asset_status')
                                    ->required()
                                    ->placeholder('Active, Inactive'),
                                Select::make('color_id')
                                    ->label('Color')
                                    ->options(\App\Models\Color::pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $assetStatus = AssetStatus::create([
                                    'asset_status' => $data['asset_status'],
                                    'color_id' => $data['color_id'],
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
                        // Hidden brand select
                        Hidden::make('brand')
                            ->reactive()
                            ->afterStateHydrated(function ($component, $state) {
                                // Initialize with current value if exists
                                if ($state) {
                                    $brand = Brand::find($state);
                                    if ($brand) {
                                        $component->state($brand->id);
                                    }
                                }
                            }),

                        // Disabled brand display
                        Select::make('brand_display')
                            ->label('Brand')
                            ->options(fn() => Brand::pluck('name', 'id'))
                            ->disabled()
                            // ->dehydrated(false)
                            ->reactive()
                            ->inlineLabel(),

                        // Model select with reactive brand updates
                        Select::make('model')
                            ->options(fn() => ProductModel::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder("Select a model")
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $model = ProductModel::find($state);
                                    if ($model) {
                                        $set('brand', $model->brand_id);
                                        $set('brand_display', $model->brand_id);
                                    }
                                } else {
                                    $set('brand', null);
                                    $set('brand_display', null);
                                }
                            })
                            ->createOptionForm([
                                Select::make('brand_id')
                                    ->label('Brand')
                                    ->required()
                                    ->options(fn() => Brand::pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->placeholder("Select a brand")
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('brands', 'name')
                                            ->validationMessages([
                                                'unique' => 'This brand already exists in the system.',
                                            ])
                                            ->placeholder($brandPlaceholder),
                                        TextInput::make('description')
                                            ->maxLength(65535)
                                            ->placeholder('Optional'),
                                    ])
                                    ->createOptionUsing(function ($data) {
                                        $brand = Brand::create([
                                            'name' => $data['name'],
                                            'description' => $data['description']
                                        ]);

                                        $recipient = \Filament\Facades\Filament::auth()->user();

                                        Notification::make()
                                            ->title('Brand Created')
                                            ->body("Brand {$brand->name} has been created.")
                                            ->success()
                                            ->send()
                                            ->color('success')
                                            ->sendToDatabase($recipient);

                                        return $brand->id;
                                    }),
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive(),
                                Textarea::make('description')
                                    ->maxLength(65535)
                                    ->placeholder('Optional'),
                            ])
                            ->createOptionUsing(function ($data) {
                                $model = ProductModel::create([
                                    'brand_id' => $data['brand_id'],
                                    'name' => $data['name'],
                                    'description' => $data['description']
                                ]);

                                $recipient = \Filament\Facades\Filament::auth()->user();

                                Notification::make()
                                    ->title('Model Created')
                                    ->body("Model {$model->name} has been created.")
                                    ->success()
                                    ->send()
                                    ->color('success')
                                    ->sendToDatabase($recipient);

                                return $model->id;
                            })
                            ->inlineLabel(),
                        Select::make('cost_code')
                            ->relationship('costCode', 'name', fn($query) => $query->orderBy('name'))
                            ->createOptionForm(fn(Form $form) => CostCodeResource::form($form))
                            ->label('Cost Code')
                            ->getSearchResultsUsing(
                                fn(string $search) => CostCode::where('name', 'like', "%{$search}%")
                                    ->limit(50)
                                    ->pluck('name')
                            )
                            ->getOptionLabelUsing(fn($value): ?string => CostCode::where('id', $value)->first()?->name)
                            ->createOptionUsing(function (array $data) {
                                $costCode = CostCode::create($data);
                                return $costCode->id;
                            })
                            ->searchable()
                            ->preload()
                            ->inlineLabel(),
                        TextInput::make('tag_number')
                            ->label('Tag Number')
                            ->nullable()
                            ->required($assetType == 'hardware')
                            ->placeholder('#A21BQWXGA')
                            ->inlineLabel()
                            ->visible($assetType == 'hardware'),
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
                            ->label('Purchase Order No.')
                            ->required()
                            ->placeholder('20230001')
                            ->inlineLabel(),
                        TextInput::make('sales_invoice_no')
                            ->label('Sales Invoice No.')
                            ->required()
                            ->placeholder('74920001')
                            ->inlineLabel(),
                        TextInput::make('purchase_order_amount')
                            ->label('Purchase Cost')
                            ->required()
                            ->numeric()
                            ->placeholder('50000')
                            ->inlineLabel(),
                        TextInput::make('requestor')
                            ->label('Requestor')
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

    public static function getEmployeeAssignmentSection(): Section
    {
        return Section::make('Employee Assignment')
            ->icon('heroicon-o-user')
            ->description('Optionally assign this asset to an employee immediately')
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('employee_id')
                            ->label('Employee')
                            ->placeholder('Search by ID or name')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return \App\Models\CEMREmployee::query()
                                    ->where(function ($query) use ($search) {
                                        $searchTerms = explode(' ', $search);

                                        foreach ($searchTerms as $term) {
                                            $query->where(function ($query) use ($term) {
                                                $query->where('id_num', 'like', "%{$term}%")
                                                    ->orWhere('first_name', 'like', "%{$term}%")
                                                    ->orWhere('last_name', 'like', "%{$term}%")
                                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                                            });
                                        }
                                    })
                                    ->limit(50)
                                    ->get()
                                    ->filter()
                                    ->mapWithKeys(function ($employee) {
                                        if (!$employee) return [];
                                        return [$employee->id_num => "{$employee->id_num} {$employee->first_name} {$employee->last_name}"];
                                    })
                                    ->toArray();
                            })
                            ->getOptionLabelUsing(function ($value) {
                                $employee = \App\Models\CEMREmployee::find($value);
                                if (!$employee) return null;

                                return "{$employee->id_num} {$employee->first_name} {$employee->last_name}";
                            })
                            ->nullable()
                            ->inlineLabel(),
                    ]),
            ])
            ->collapsible()
            ->collapsed();
    }

    public static function getSoftwareBrandSection($brandPlaceholder): Section
    {
        return Section::make('Asset Details')
            ->icon('heroicon-o-clipboard-document-list')
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('asset_type')
                            ->required()
                            ->default('software')
                            ->disabled()
                            ->inlineLabel(),
                        Select::make('asset_status')
                            ->label('Asset Status')
                            ->options(fn() => AssetStatus::pluck('asset_status', 'id'))
                            ->default(1)
                            ->createOptionForm([
                                TextInput::make('asset_status')
                                    ->required()
                                    ->placeholder('Active, Inactive'),
                                Select::make('color_id')
                                    ->label('Color')
                                    ->options(\App\Models\Color::pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $assetStatus = AssetStatus::create([
                                    'asset_status' => $data['asset_status'],
                                    'color_id' => $data['color_id'],
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
                        TextInput::make('software_brand')
                            ->label('Brand')
                            ->placeholder($brandPlaceholder)
                            ->inlineLabel(),
                        Select::make('cost_code')
                            ->relationship('costCode', 'name', fn($query) => $query->orderBy('name'))
                            ->createOptionForm(fn(Form $form) => CostCodeResource::form($form))
                            ->label('Cost Code')
                            ->getSearchResultsUsing(
                                fn(string $search) => CostCode::where('name', 'like', "%{$search}%")
                                    ->limit(50)
                                    ->pluck('name')
                            )
                            ->getOptionLabelUsing(fn($value): ?string => CostCode::where('id', $value)->first()?->name)
                            ->createOptionUsing(function (array $data) {
                                $costCode = CostCode::create($data);
                                return $costCode->id;
                            })
                            ->searchable()
                            ->preload()
                            ->inlineLabel(),
                    ]),
            ]);
    }
}
