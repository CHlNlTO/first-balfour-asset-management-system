<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use App\Filament\Resources\AssetResource\Forms\CommonFormComponents;
use App\Models\HardwareType;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Purchase;
use App\Models\Lifecycle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Set;

class CreateHardwareAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;
    public ?string $assetType = 'hardware';

    public ?string $brandPlaceholder = 'e.g. Dell, HP, Lenovo';

    public ?string $modelPlaceholder = 'e.g. Optiplex 7010, EliteBook 840 G7, ThinkPad X1 Carbon';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column (left side)
                Group::make()
                    ->schema([
                        CommonFormComponents::getBasicDetailsSection($this->assetType, $this->brandPlaceholder, $this->modelPlaceholder),

                        Section::make('Hardware Details')
                            ->icon('heroicon-o-computer-desktop')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('hardware_type')
                                            ->label('Hardware Type')
                                            ->options(fn() => HardwareType::pluck('hardware_type', 'id'))
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('hardware_type')
                                                    ->required()
                                                    ->placeholder('e.g. Desktop, Laptop, Server'),
                                            ])
                                            ->createOptionUsing(function ($data) {
                                                $hardwareType = HardwareType::create(['hardware_type' => $data['hardware_type']]);

                                                Notification::make()
                                                    ->title('Record Created')
                                                    ->body("Hardware Type {$hardwareType->hardware_type} has been created.")
                                                    ->success()
                                                    ->send();

                                                return $hardwareType->id;
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->inlineLabel(),
                                        TextInput::make('serial_number')
                                            ->label('Serial No.')
                                            ->required()
                                            ->placeholder('e.g. SN123456789')
                                            ->inlineLabel(),
                                        TextInput::make('manufacturer')
                                            ->required()
                                            ->placeholder('e.g. Dell, HP, Lenovo')
                                            ->inlineLabel(),
                                        TextInput::make('mac_address')
                                            ->nullable()
                                            ->placeholder('e.g. 00:1A:2B:3C:4D:5E')
                                            ->inlineLabel(),
                                        TextInput::make('pc_name')
                                            ->nullable()
                                            ->placeholder('e.g. DESKTOP-ABC123')
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
                                        Textarea::make('specifications')
                                            ->required()
                                            ->placeholder('e.g. Intel Core i7-12700K, 32GB RAM, 1TB NVMe SSD')
                                            ->inlineLabel(),
                                        TextInput::make('accessories')
                                            ->nullable()
                                            ->placeholder('e.g. Keyboard, Mouse, Monitor')
                                            ->inlineLabel(),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                // Sidebar column (right side)
                Group::make()
                    ->schema([
                        CommonFormComponents::getVendorSection(),
                        CommonFormComponents::getPurchaseSection(),
                        CommonFormComponents::getLifecycleSection(),
                    ])
                    ->columnSpan(['lg' => 1])
            ])
            ->columns([
                'lg' => 3
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['asset_type'] = 'hardware';
        return $data;
    }

    protected function handleRecordCreation(array $data): Asset
    {
        Log::info("Creating Hardware Asset with data:", $data);

        return DB::transaction(function () use ($data) {
            // Create the main asset record
            $asset = Asset::create([
                'asset_type' => $this->assetType,
                'asset_status' => $data['asset_status'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'department_project_code' => $data['department_project_code'],
            ]);

            // Create the hardware record
            Hardware::create([
                'asset_id' => $asset->id,
                'hardware_type' => $data['hardware_type'],
                'serial_number' => $data['serial_number'],
                'specifications' => $data['specifications'],
                'accessories' => $data['accessories'] ?? null,
                'manufacturer' => $data['manufacturer'],
                'mac_address' => $data['mac_address'] ?? null,
                'pc_name' => $data['pc_name'] ?? null,
                'warranty_expiration' => $data['warranty_expiration'] ?? null,
            ]);

            // Create lifecycle record
            Lifecycle::create([
                'asset_id' => $asset->id,
                'acquisition_date' => $data['acquisition_date'],
                'retirement_date' => $data['retirement_date'] ?? null,
            ]);

            // Create purchase record
            Purchase::create([
                'asset_id' => $asset->id,
                'purchase_order_no' => $data['purchase_order_no'],
                'sales_invoice_no' => $data['sales_invoice_no'],
                'purchase_order_date' => $data['purchase_order_date'],
                'purchase_order_amount' => $data['purchase_order_amount'],
                'vendor_id' => $data['vendor_id'],
            ]);

            return $asset;
        });
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Hardware Asset Created Successfully')
            ->body("Asset {$this->record->brand} {$this->record->model} has been created.");
    }


    protected function getRedirectUrl(): string
    {
        return AssetResource::getUrl('index');
    }
}
