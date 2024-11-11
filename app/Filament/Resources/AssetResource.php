<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use App\Models\AssetStatus;
use App\Models\HardwareType;
use App\Models\SoftwareType;
use App\Models\LicenseType;
use App\Models\PeripheralType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\AssetResource\RelationManagers\AssignmentsRelationManager;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\HTML;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Repeater::make('Asset Information')
                //     ->schema([
                Section::make('Asset Details')
                    ->schema([
                        Grid::make(2)
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
                                    })
                                    ->inlineLabel(),
                                Select::make('asset_status')
                                    ->label('Asset Status')
                                    ->options(fn() => AssetStatus::all()->pluck('asset_status', 'id'))
                                    ->default(1)
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('asset_status')->required(),
                                    ])
                                    ->createOptionUsing(function ($data) {
                                        return AssetStatus::create(['asset_status' => $data['asset_status']])->id;
                                    })
                                    ->inlineLabel(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('brand')->required()->inlineLabel(),
                                TextInput::make('model')->required()->inlineLabel(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('department_project_code')
                                    ->label('Dept/Project Code')
                                    ->nullable()
                                    ->inlineLabel(),
                            ]),
                    ]),

                Section::make('Hardware Details')
                    ->hidden(fn(callable $get) => $get('show_hardware') !== true)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('hardware_type')
                                    ->label('Hardware Type')
                                    ->options(HardwareType::all()->pluck('hardware_type', 'id'))
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('hardware_type')->required(),
                                    ])
                                    ->reactive()
                                    ->inlineLabel(),
                                TextInput::make('serial_number')
                                    ->label('Serial No.')
                                    ->required()
                                    ->inlineLabel(),
                                TextInput::make('manufacturer')
                                    ->required()
                                    ->inlineLabel(),
                                TextInput::make('mac_address')
                                    ->nullable()
                                    ->inlineLabel(),
                                TextInput::make('pc_name')
                                    ->nullable()
                                    ->inlineLabel(),
                                DatePicker::make('warranty_expiration')
                                    ->label('Warranty Exp.')
                                    ->displayFormat('m/d/Y')
                                    ->format('Y-m-d')
                                    ->nullable()
                                    ->inlineLabel(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextArea::make('specifications')
                                    ->required()
                                    ->inlineLabel(),
                                TextInput::make('accessories')
                                    ->nullable()
                                    ->inlineLabel(),
                            ]),
                    ]),

                Section::make('Software Details')
                    ->hidden(fn(callable $get) => $get('show_software') !== true)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('version')
                                    ->nullable()
                                    ->inlineLabel(),
                                TextInput::make('license_key')
                                    ->nullable()
                                    ->inlineLabel(),
                                TextInput::make('pc_name')
                                    ->nullable()
                                    ->inlineLabel(),
                                Select::make('software_type')
                                    ->label('Software Type')
                                    ->options(SoftwareType::all()->pluck('software_type', 'id'))
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('software_type')->required(),
                                    ])
                                    ->reactive()
                                    ->inlineLabel(),
                                Select::make('license_type')
                                    ->label('License Type')
                                    ->options(LicenseType::all()->pluck('license_type', 'id'))
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('license_type')->required(),
                                    ])
                                    ->reactive()
                                    ->inlineLabel(),
                            ]),
                    ]),

                Section::make('Peripherals Details')
                    ->hidden(fn(callable $get) => $get('show_peripherals') !== true)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('peripherals_type')
                                    ->label('Peripheral Type')
                                    ->options(PeripheralType::all()->pluck('peripherals_type', 'id'))
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('peripherals_type')->required(),
                                    ])
                                    ->reactive()
                                    ->inlineLabel(),
                                TextInput::make('serial_number')
                                    ->label('Serial No.')
                                    ->required()
                                    ->inlineLabel(),
                                TextInput::make('manufacturer')
                                    ->required()
                                    ->inlineLabel(),
                                DatePicker::make('warranty_expiration')
                                    ->label('Warranty Exp.')
                                    ->displayFormat('m/d/Y')
                                    ->format('Y-m-d')
                                    ->inlineLabel(),
                            ]),
                        Grid::make(1)
                            ->schema([
                                TextArea::make('specifications')
                                    ->required()
                                    ->inlineLabel(),
                            ]),
                    ]),

                Section::make('Purchase Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('purchase_order_no')
                                    ->required()
                                    ->numeric()
                                    ->inlineLabel(),
                                TextInput::make('sales_invoice_no')
                                    ->required()
                                    ->numeric()
                                    ->inlineLabel(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('purchase_order_date')
                                    ->required()
                                    ->inlineLabel(),
                                TextInput::make('purchase_order_amount')
                                    ->label('PO Cost')
                                    ->required()
                                    ->numeric()
                                    ->inlineLabel(),
                                TextInput::make('requestor')
                                    ->nullable()
                                    ->inlineLabel(),
                            ]),
                    ]),

                Section::make('Lifecycle Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('acquisition_date')
                                    ->required()
                                    ->inlineLabel(),
                                DatePicker::make('retirement_date')
                                    ->nullable()
                                    ->minDate(fn($get) => $get('acquisition_date'))
                                    ->inlineLabel(),
                            ]),
                    ]),

                Section::make('Vendor Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('vendor_id')
                                    ->label('Vendor')
                                    ->options(fn() => \App\Models\Vendor::pluck('name', 'id'))
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Vendor Name')
                                            ->required(),
                                        TextInput::make('address_1')
                                            ->label('Address 1')
                                            ->required(),
                                        TextInput::make('address_2')
                                            ->label('Address 2')
                                            ->nullable(),
                                        TextInput::make('city')
                                            ->nullable(),
                                        TextInput::make('tel_no_1')
                                            ->label('Telephone No. 1')
                                            ->tel()
                                            ->nullable(),
                                        TextInput::make('tel_no_2')
                                            ->label('Telephone No. 2')
                                            ->tel()
                                            ->nullable(),
                                        TextInput::make('contact_person')
                                            ->nullable(),
                                        TextInput::make('mobile_number')
                                            ->numeric()
                                            ->nullable(),
                                        TextInput::make('email')
                                            ->email()
                                            ->nullable(),
                                        TextInput::make('url')
                                            ->nullable(),
                                        Textarea::make('remarks')
                                            ->nullable(),
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
                            ]),
                    ]),
            ]);
        //         ->createItemButtonLabel('Add Asset')
        //         ->label('Asset Information')
        //         ->columnSpanFull()
        //         ->required(),
        // ]);
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
                    })
                    ->placeholder('N/A'),
                TextColumn::make('asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('asset_status')
                    ->label('Asset Status')
                    ->getStateUsing(function (Asset $record): string {
                        $assetStatus = AssetStatus::find($record->asset_status);
                        return $assetStatus ? $assetStatus->asset_status : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'gray',
                        'In Transfer' => 'primary',
                        'Maintenance' => 'warning',
                        'Lost' => 'gray',
                        'Disposed' => 'gray',
                        'Stolen' => 'danger',
                        'Unknown' => 'gray',
                        'Sold' => 'success',
                        default => 'gray',
                    })
                    ->placeholder('N/A'),
                TextColumn::make('asset')
                    ->label('Asset Name')
                    ->getStateUsing(fn(Asset $record) => $record->asset)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereRaw("CONCAT(assets.brand, ' ', assets.model) LIKE ?", ["%{$search}%"]);
                    })
                    ->placeholder('N/A'),
                TextColumn::make('details')
                    ->label('Specifications/Version')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('hardware.specifications', 'like', "%{$search}%")
                            ->orWhere('software.version', 'like', "%{$search}%")
                            ->orWhere('peripherals.specifications', 'like', "%{$search}%");
                    })
                    ->getStateUsing(fn($record) => $record->details)
                    ->placeholder('N/A'),
                TextColumn::make('department_project_code')
                    ->label('Department/Project Code')
                    ->getStateUsing(function (Asset $record): string {
                        return "{$record->department_project_code}";
                    })
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.created_at', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhere('assets.updated_at', 'like', "%{$search}%");
                    })
                    ->placeholder('N/A'),
            ])
            ->filters([
                SelectFilter::make('department_project_code')
                    ->label("Filter by Department/Project Code")
                    ->searchable()
                    ->indicator('Status')
                    ->options(function () {
                        return Asset::whereNotNull('department_project_code')
                            ->pluck('department_project_code', 'department_project_code')
                            ->filter(fn($value) => !is_null($value))
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                'asset_type',
                'asset_status',
                'department_project_code',
            ])
            ->defaultSort('assets.id', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $query->leftJoin('hardware', 'assets.id', '=', 'hardware.asset_id')
                    ->leftJoin('software', 'assets.id', '=', 'software.asset_id')
                    ->leftJoin('peripherals', 'assets.id', '=', 'peripherals.asset_id')
                    ->select(
                        'assets.*',
                        'hardware.specifications as hardware_specifications',
                        'software.version as software_version',
                        'peripherals.specifications as peripherals_specifications',
                    );
            });
    }

    public static function getRelations(): array
    {
        return [
            AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
