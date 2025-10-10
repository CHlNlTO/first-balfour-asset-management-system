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
                                            ->createOptionForm([
                                                TextInput::make('software_type')
                                                    ->required()
                                                    ->placeholder('Operating System, Application'),
                                            ])
                                            ->createOptionUsing(function ($data) {
                                                $softwareType = SoftwareType::create(['software_type' => $data['software_type']]);

                                                Notification::make()
                                                    ->title('Record Created')
                                                    ->body("Software Type {$softwareType->software_type} has been created.")
                                                    ->success()
                                                    ->send();

                                                return $softwareType->id;
                                            })
                                            ->reactive()
                                            ->inlineLabel(),
                                        Select::make('license_type')
                                            ->label('License Type')
                                            ->options(LicenseType::pluck('license_type', 'id'))
                                            ->createOptionForm([
                                                TextInput::make('license_type')
                                                    ->required()
                                                    ->placeholder('Perpetual, Subscription'),
                                            ])
                                            ->createOptionUsing(function ($data) {
                                                $licenseType = LicenseType::create(['license_type' => $data['license_type']]);

                                                Notification::make()
                                                    ->title('Record Created')
                                                    ->body("License Type {$licenseType->license_type} has been created.")
                                                    ->success()
                                                    ->send();

                                                return $licenseType->id;
                                            })
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
        Log::info("Creating Software Asset with data:", $data);

        return DB::transaction(function () use ($data) {
            // Handle software brand - create a brand and model from the brand name
            $modelId = null;
            if (!empty($data['software_brand'])) {
                $modelId = $this->createSoftwareBrandModel($data['software_brand']);
            }

            // Create the main asset record
            $asset = Asset::create([
                'asset_type' => $this->assetType,
                'asset_status' => $data['asset_status'] ?? null,
                'model_id' => $modelId,
                'cost_code' => $data['cost_code'] ?? null,
            ]);

            // Create the software record
            Software::create([
                'asset_id' => $asset->id,
                'software_type' => $data['software_type'] ?? null,
                'license_type' => $data['license_type'] ?? null,
                'version' => $data['version'] ?? null,
                'license_key' => $data['license_key'] ?? null,
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

    protected function createSoftwareBrandModel(string $brandName): int
    {
        // Find or create the brand
        $brand = \App\Models\Brand::firstOrCreate(
            ['name' => $brandName],
            ['name' => $brandName, 'description' => "Software brand: {$brandName}"]
        );

        // Create a model with the same name as the brand for software
        $model = \App\Models\ProductModel::firstOrCreate(
            ['brand_id' => $brand->id, 'name' => $brandName],
            ['brand_id' => $brand->id, 'name' => $brandName, 'description' => $brandName]
        );

        Log::info("Created/found brand and model for software", [
            'brand' => $brand->name,
            'model' => $model->name,
            'model_id' => $model->id
        ]);

        return $model->id;
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
            ->when(
                $this->record->model?->brand?->name,
                fn($notification) => $notification->body(
                    Str::markdown(
                        ($this->record->model->brand->name ?? 'Software') . ' has been created'
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
