<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use App\Filament\Resources\AssetResource\Forms\CommonFormComponents;
use App\Helpers\StatusSynchronizationHelper;
use App\Models\HardwareType;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\HardwareSoftware;
use App\Models\Purchase;
use App\Models\Lifecycle;
use App\Models\Software;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class CreateHardwareAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;
    public ?string $assetType = 'hardware';

    public ?string $brandPlaceholder = 'Dell, HP, Lenovo';

    public ?string $modelPlaceholder = 'Optiplex 7010, EliteBook 840 G7, ThinkPad X1 Carbon';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column (left side)
                Group::make()
                    ->schema([
                        CommonFormComponents::getEmployeeAssignmentSection(),

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
                                                    ->placeholder('Desktop, Laptop, Server'),
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
                                            ->placeholder('SN123456789')
                                            ->inlineLabel(),
                                        TextInput::make('mac_address')
                                            ->label('MAC Address')
                                            ->nullable()
                                            ->placeholder('00:1A:2B:3C:4D:5E')
                                            ->inlineLabel(),
                                        TextInput::make('accessories')
                                            ->nullable()
                                            ->placeholder('Keyboard, Mouse, Monitor')
                                            ->inlineLabel(),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Textarea::make('specifications')
                                            ->required()
                                            ->placeholder('Intel Core i7-12700K, 32GB RAM, 1TB NVMe SSD')
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
            try {
                // Create the main asset record
                $asset = Asset::create([
                    'asset_type' => $this->assetType,
                    'asset_status' => $data['asset_status'] ?? null,
                    'model_id' => $data['model'] ?? null,
                    'cost_code' => $data['cost_code'] ?? null,
                    'tag_number' => $data['tag_number'],
                ]);

                Log::info("Asset created with data:", $asset->toArray());

                // Create the hardware record
                $hardware = Hardware::create([
                    'asset_id' => $asset->id,
                    'hardware_type' => $data['hardware_type'],
                    'serial_number' => $data['serial_number'],
                    'specifications' => $data['specifications'],
                    'accessories' => $data['accessories'] ?? null,
                    'manufacturer' => $data['manufacturer'] ?? null,
                    'mac_address' => $data['mac_address'] ?? null,
                    'warranty_expiration' => $data['retirement_date'] ?? null,
                ]);

                // Attach software if selected
                if (!empty($data['software'])) {
                    $softwareRecords = Software::whereIn('asset_id', $data['software'])->pluck('asset_id');

                    if ($softwareRecords->isNotEmpty()) {
                        foreach ($softwareRecords as $softwareAssetId) {
                            HardwareSoftware::create([
                                'hardware_asset_id' => $asset->id,
                                'software_asset_id' => $softwareAssetId
                            ]);
                        }
                    }
                }

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
                    'purchase_order_date' => $data['acquisition_date'],
                    'purchase_order_amount' => $data['purchase_order_amount'],
                    'vendor_id' => $data['vendor_id'],
                    'requestor' => $data['requestor'],
                ]);

                // Create assignment if employee is selected
                if (!empty($data['employee_id'])) {
                    // Get Assignment Status by matching Asset Status value
                    $assignmentStatusId = null;
                    if (!empty($data['asset_status'])) {
                        $assignmentStatusId = StatusSynchronizationHelper::findOrCreateAssignmentStatusByAssetStatus($data['asset_status']);
                    } else {
                        // Fallback to "Active" status if no asset_status is set
                        $activeStatus = \App\Models\AssignmentStatus::where('assignment_status', 'Active')->first();
                        $assignmentStatusId = $activeStatus ? $activeStatus->id : 3;
                    }

                    $assignment = \App\Models\Assignment::create([
                        'asset_id' => $asset->id,
                        'employee_id' => $data['employee_id'],
                        'assignment_status' => $assignmentStatusId,
                        'start_date' => $data['acquisition_date'],
                        'end_date' => null, // No end date for immediate assignment
                    ]);

                    // Sync Asset Status with Assignment Status for the most recent assignment
                    StatusSynchronizationHelper::syncAssetStatusFromAssignment($assignment);
                }

                return $asset;
            } catch (\Exception $e) {
                Log::error('Error in handleRecordCreation: ' . $e->getMessage());
                throw new \Exception('Error Processing Request');
            }
        });
    }

    protected function getCreatedNotification(): ?Notification
    {
        $recipient = \Filament\Facades\Filament::auth()->user();

        return Notification::make()
            ->success()
            ->title('Hardware Asset Created')
            ->when(
                ($this->record->model && $this->record->model->brand && $this->record->model->brand->name)
                    || ($this->record->model && $this->record->model->name),
                fn($notification) => $notification->body(
                    Str::markdown(
                        trim(($this->record->model->brand->name ?? '') . ' ' . ($this->record->model->name ?? '')) . ' has been created'
                    )
                )
            )
            ->color('success')
            ->sendToDatabase($recipient);
    }


    protected function getRedirectUrl(): string
    {
        return AssetResource::getUrl('index');
    }
}
