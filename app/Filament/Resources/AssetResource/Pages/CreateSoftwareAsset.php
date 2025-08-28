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
use App\Models\SoftwareType;
use App\Models\LicenseType;
use Filament\Forms\Components\Group;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Purchase;
use App\Models\Lifecycle;
use App\Models\PCName;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreateSoftwareAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    public ?string $assetType = 'software';

    public ?string $brandPlaceholder = 'Microsoft, Adobe, Autodesk';

    public ?string $modelPlaceholder = 'Windows, Adobe Photoshop, AutoCAD';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column (left side)
                Group::make()
                    ->schema([
                        CommonFormComponents::getEmployeeAssignmentSection(),

                        CommonFormComponents::getBasicDetailsSection($this->assetType, $this->brandPlaceholder, $this->modelPlaceholder),

                        Section::make('Software Details')
                            ->icon('heroicon-o-cpu-chip')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('software_type')
                                            ->label('Software Type')
                                            ->options(SoftwareType::pluck('software_type', 'id'))
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('software_type')
                                                    ->required()
                                                    ->placeholder('Operating System, Application'),
                                            ])
                                            ->reactive()
                                            ->inlineLabel(),
                                        Select::make('license_type')
                                            ->label('License Type')
                                            ->options(LicenseType::pluck('license_type', 'id'))
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('license_type')
                                                    ->required()
                                                    ->placeholder('Perpetual, Subscription'),
                                            ])
                                            ->reactive()
                                            ->inlineLabel(),
                                        TextInput::make('version')
                                            ->nullable()
                                            ->placeholder('2.1.0, v3.5')
                                            ->inlineLabel(),
                                        TextInput::make('license_key')
                                            ->nullable()
                                            ->placeholder('XXXX-YYYY-ZZZZ')
                                            ->inlineLabel(),
                                        Select::make('pc_name')
                                            ->label('PC Name')
                                            ->options(fn() => PCName::pluck('name', 'id'))
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->placeholder('DESKTOP-ABC123'),
                                                TextInput::make('description')
                                                    ->nullable()
                                                    ->placeholder('Main Office Desktop'),
                                            ])
                                            ->createOptionUsing(function ($data) {
                                                $pcName = PCName::create(['name' => $data['name'], 'description' => $data['description']]);

                                                Notification::make()
                                                    ->title('Record Created')
                                                    ->body("PC Name {$pcName->name} has been created.")
                                                    ->success()
                                                    ->send();

                                                return $pcName->id;
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->inlineLabel(),
                                    ]),
                            ]),

                        Section::make("Attach to Hardware")
                            ->icon('heroicon-o-link')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('hardware')
                                            ->label('Hardware')
                                            ->options(function () {
                                                return Asset::where('asset_type', 'hardware')
                                                    ->get()
                                                    ->pluck('asset', 'id');
                                            })
                                            ->searchable(['id', 'brand', 'model'])
                                            ->multiple()
                                            ->preload()
                                            ->inlineLabel(),
                                    ]),
                            ])
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
        Log::info("Creating Software Asset with data:", $data);

        return DB::transaction(function () use ($data) {
            // Create the main asset record
            $asset = Asset::create([
                'asset_type' => $this->assetType,
                'asset_status' => $data['asset_status'],
                'model_id' => $data['model'],
                'cost_code' => $data['cost_code'],
            ]);

            // Create the software record
            Software::create([
                'asset_id' => $asset->id,
                'software_type' => $data['software_type'],
                'license_type' => $data['license_type'],
                'version' => $data['version'] ?? null,
                'license_key' => $data['license_key'] ?? null,
                'pc_name_id' => $data['pc_name'] ?? null,
            ]);



            // Attach software if selected
            if (!empty($data['hardware'])) {
                Log::info("Attaching software to hardware", $data['hardware']);

                // Get the hardware records
                $hardwareRecords = Hardware::whereIn('asset_id', $data['hardware'])
                    ->pluck('asset_id');

                if ($hardwareRecords->isNotEmpty()) {
                    // Get the software record we just created
                    $software = Software::where('asset_id', $asset->id)->first();

                    // Attach hardware to software
                    $software->hardware()->attach(
                        $hardwareRecords->mapWithKeys(function ($hardwareAssetId) use ($asset) {
                            return [$hardwareAssetId => [
                                'hardware_asset_id' => $hardwareAssetId,
                                'software_asset_id' => $asset->id
                            ]];
                        })->all()
                    );
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
                'requestor' => $data['requestor'] ?? null,
            ]);

            // Create assignment if employee is selected
            if (!empty($data['employee_id'])) {
                \App\Models\Assignment::create([
                    'asset_id' => $asset->id,
                    'employee_id' => $data['employee_id'],
                    'assignment_status' => 3, // Active status
                    'start_date' => $data['acquisition_date'],
                    'end_date' => null, // No end date for immediate assignment
                ]);
            }

            return $asset;
        });
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['asset_type'] = 'software';
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        $recipient = \Filament\Facades\Filament::auth()->user();

        return Notification::make()
            ->success()
            ->title('Software Asset Created')
            ->body(Str::markdown("{$this->record->model->brand->name} {$this->record->model->name} has been created"))
            ->color('success')
            ->sendToDatabase($recipient);
    }

    protected function getRedirectUrl(): string
    {
        return AssetResource::getUrl('index');
    }
}
