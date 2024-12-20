<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use App\Filament\Resources\AssetResource\Forms\CommonFormComponents;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use App\Models\PeripheralType;
use Filament\Forms\Components\Group;
use App\Models\Asset;
use App\Models\Peripheral;
use App\Models\Purchase;
use App\Models\Lifecycle;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreatePeripheralsAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    public ?string $assetType = 'peripherals';

    public ?string $brandPlaceholder = 'Dell, HP, Lenovo';

    public ?string $modelPlaceholder = 'Techno Bag, HP Keyboard, Lenovo Mouse';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column (left side)
                Group::make()
                    ->schema([
                        CommonFormComponents::getBasicDetailsSection($this->assetType, $this->brandPlaceholder, $this->modelPlaceholder),

                        Section::make('Peripherals Details')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('peripherals_type')
                                            ->label('Peripheral Type')
                                            ->options(PeripheralType::pluck('peripherals_type', 'id'))
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('peripherals_type')
                                                    ->required()
                                                    ->placeholder('Monitor, Printer'),
                                            ])
                                            ->reactive()
                                            ->searchable()
                                            ->inlineLabel(),
                                        TextInput::make('serial_number')
                                            ->label('Serial No.')
                                            ->required()
                                            ->placeholder('SN123456789')
                                            ->inlineLabel(),
                                        TextInput::make('manufacturer')
                                            ->required()
                                            ->placeholder('Dell, HP')
                                            ->inlineLabel(),
                                        DatePicker::make('warranty_expiration')
                                            ->label('Warranty Exp.')
                                            ->displayFormat('m/d/Y')
                                            ->format('Y-m-d')
                                            ->nullable()
                                            ->inlineLabel(),
                                    ]),
                                Grid::make(1)
                                    ->schema([
                                        Textarea::make('specifications')
                                            ->required()
                                            ->placeholder("27'' 4K Monitor, 144Hz refresh rate")
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

    protected function handleRecordCreation(array $data): Asset
    {
        Log::info("Creating Peripherals Asset with data:", $data);

        return DB::transaction(function () use ($data) {
            // Create the main asset record
            $asset = Asset::create([
                'asset_type' => $this->assetType,
                'asset_status' => $data['asset_status'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'department_project_code' => $data['department_project_code'],
                'tag_number' => $data['tag_number'],
            ]);

            // Create the peripherals record
            Peripheral::create([
                'asset_id' => $asset->id,
                'peripherals_type' => $data['peripherals_type'],
                'serial_number' => $data['serial_number'],
                'specifications' => $data['specifications'],
                'manufacturer' => $data['manufacturer'],
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
                'requestor' => $data['requestor'] ?? null,
            ]);

            return $asset;
        });
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['asset_type'] = 'peripherals';
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        $recipient = auth()->user();

        return Notification::make()
            ->success()
            ->title('Peripheral Asset Created')
            ->body(Str::markdown("**{$this->record->brand} {$this->record->model}** has been created."))
            ->color('success')
            ->sendToDatabase($recipient);
    }

    protected function getRedirectUrl(): string
    {
        return AssetResource::getUrl('index');
    }
}
