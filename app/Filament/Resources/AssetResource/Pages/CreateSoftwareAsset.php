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
use App\Models\Software;
use App\Models\Purchase;
use App\Models\Lifecycle;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreateSoftwareAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    public ?string $assetType = 'software';

    public ?string $brandPlaceholder = 'e.g. Microsoft, Adobe, Autodesk';

    public ?string $modelPlaceholder = 'e.g. Windows, Adobe Photoshop, AutoCAD';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column (left side)
                Group::make()
                    ->schema([
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
                                                    ->placeholder('e.g. Operating System, Application'),
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
                                                    ->placeholder('e.g. Perpetual, Subscription'),
                                            ])
                                            ->reactive()
                                            ->inlineLabel(),
                                        TextInput::make('version')
                                            ->nullable()
                                            ->placeholder('e.g. 2.1.0, v3.5')
                                            ->inlineLabel(),
                                        TextInput::make('license_key')
                                            ->nullable()
                                            ->placeholder('e.g. XXXX-YYYY-ZZZZ')
                                            ->inlineLabel(),
                                        TextInput::make('pc_name')
                                            ->nullable()
                                            ->placeholder('e.g. DESKTOP-ABC123')
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
            // Create the main asset record
            $asset = Asset::create([
                'asset_type' => $this->assetType,
                'asset_status' => $data['asset_status'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'department_project_code' => $data['department_project_code'],
            ]);

            // Create the software record
            Software::create([
                'asset_id' => $asset->id,
                'software_type' => $data['software_type'],
                'license_type' => $data['license_type'],
                'version' => $data['version'] ?? null,
                'license_key' => $data['license_key'] ?? null,
                'pc_name' => $data['pc_name'] ?? null,
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['asset_type'] = 'software';
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        $recipient = auth()->user();

        return Notification::make()
            ->success()
            ->title('Software Asset Created')
            ->body(Str::markdown("*{$this->record->brand} {$this->record->model}*"))
            ->color('success')
            ->sendToDatabase($recipient);
    }

    protected function getRedirectUrl(): string
    {
        return AssetResource::getUrl('index');
    }
}
