<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\AssetStatus;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Purchase Information')
                    ->schema([
                        TextInput::make('purchase_order_no')
                            ->label('Purchase Order No.')
                            ->required()
                            ->numeric()
                            ->columnSpan(1),
                        TextInput::make('sales_invoice_no')
                            ->label('Sales Invoice No.')
                            ->required()
                            ->numeric()
                            ->columnSpan(1),
                        DatePicker::make('purchase_order_date')
                            ->label('Purchase Order Date')
                            ->required(),
                        TextInput::make('purchase_order_amount')
                            ->label('Purchase Order Amount')
                            ->required()
                            ->numeric()
                            ->columnSpan(1),
                        TextInput::make('requestor')
                            ->label('Requestor')
                            ->nullable(),
                    ]),
                Fieldset::make('Asset Details')
                    ->schema([
                        Select::make('asset_type')
                            ->options([
                                'hardware' => 'Hardware',
                                'software' => 'Software',
                                'peripherals'=> 'peripherals',
                            ])
                            ->required()
                            ->label('Asset Type')
                            ->reactive()
                            ->autofocus()
                            ->disabled(),
                        Select::make('asset_status')
                            ->label('Asset Status')
                            ->options(function () {
                                return AssetStatus::all()->pluck('asset_status', 'id');
                            })
                            ->required()
                            ->reactive()
                            ->live(),
                        TextInput::make('brand')->label('Brand')->required(),
                        TextInput::make('model')->label('Model')->required(),
                        TextInput::make('cost_code')->label('Department/Project Code')->nullable(),
                    ]),
                Fieldset::make('Hardware Details')
                    ->hidden(fn (callable $get) => $get('asset_type') !== 'hardware')
                    ->schema([
                        TextInput::make('specifications')->label('Specifications')->required(),
                        TextInput::make('serial_number')->label('Serial Number')->required(),
                        TextInput::make('manufacturer')->label('Manufacturer')->required(),
                        TextInput::make('mac_address')->label('MAC Address')->nullable(),
                        TextInput::make('accessories')->label('Accessories')->nullable(),
                        TextInput::make('pc_name')->label('PC Name')->nullable(),
                        DatePicker::make('warranty_expiration')
                            ->label('Warranty Expiration')
                            ->displayFormat('m/d/Y')
                            ->format('Y-m-d')
                            ->seconds(false),
                    ]),
                Fieldset::make('Software Details')
                    ->hidden(fn (callable $get) => $get('asset_type') !== 'software')
                    ->schema([
                        TextInput::make('version')->label('Version')->required(),
                        TextInput::make('license_key')->label('License Key')->required(),
                        TextInput::make('license_type')->label('License Type')->required(),
                        TextInput::make('pc_name')->label('PC Name')->nullable(),
                    ]),
                Fieldset::make('Peripherals Details')
                    ->hidden(fn (callable $get) => $get('asset_type') !== 'peripherals')
                    ->schema([
                        TextInput::make('peripherals_type')->label('Peripherals Type')->required(),
                        TextInput::make('specifications')->label('Specifications')->required(),
                        TextInput::make('serial_number')->label('Serial Number')->required(),
                        TextInput::make('manufacturer')->label('Manufacturer')->required(),
                        DatePicker::make('warranty_expiration')
                            ->label('Warranty Expiration')
                            ->displayFormat('m/d/Y')
                            ->format('Y-m-d')
                            ->seconds(false),
                    ]),
                Fieldset::make('Lifecycle Information')
                    ->schema([
                        DatePicker::make('acquisition_date')
                            ->label('Acquisition Date')
                            ->required(),
                        DatePicker::make('retirement_date')
                            ->label('Retirement Date')
                            ->required(),
                    ]),
                Fieldset::make('Vendor Information')
                    ->schema([
                        Select::make('vendor_id')
                            ->label('Vendor')
                            ->options(function () {
                                return \App\Models\Vendor::all()->pluck('name', 'id');
                            })
                            ->required(),
                    ]),
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info('Initial Record Datas: ', $this->record->toArray());

        $asset = $this->record->asset;
        $data['asset_type'] = $asset->asset_type;
        $data['asset_status'] = $asset->assetStatus->id;
        $data['brand'] = $asset->brand;
        $data['model'] = $asset->model;
        $data['cost_code'] = $asset->cost_code;
        $data['acquisition_date'] = $asset->lifecycle->acquisition_date;
        $data['retirement_date'] = $asset->lifecycle->retirement_date;
        $data['vendor_id'] = $this->record->vendor_id;

        if ($asset->asset_type === 'hardware') {
            $hardware = $asset->hardware;
            if ($hardware) {
                $data['specifications'] = $hardware->specifications;
                $data['serial_number'] = $hardware->serial_number;
                $data['manufacturer'] = $hardware->manufacturer;
                $data['mac_address'] = $hardware->mac_address;
                $data['accessories'] = $hardware->accessories;
                $data['pc_name'] = $hardware->pc_name;
                $data['warranty_expiration'] = $hardware->warranty_expiration;
            }
        } elseif ($asset->asset_type === 'software') {
            $software = $asset->software;
            if ($software) {
                $data['version'] = $software->version;
                $data['license_key'] = $software->license_key;
                $data['license_type'] = $software->license_type;
                $data['pc_name'] = $software->pc_name;
            }
        } elseif ($asset->asset_type === 'peripherals') {
            $peripherals = $asset->peripherals;
            if ($peripherals) {
                $data['peripherals_type'] = $peripherals->peripherals_type;
                $data['specifications'] = $peripherals->specifications;
                $data['serial_number'] = $peripherals->serial_number;
                $data['manufacturer'] = $peripherals->manufacturer;
                $data['warranty_expiration'] = $peripherals->warranty_expiration;
            }
        }

        Log::info('Mutated Data Before Fill: ', $data);

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        Log::info('Update Data Before Processing: ', $data);

        return DB::transaction(function () use ($record, $data) {
            $record->update([
                'sales_invoice_no' => $data['sales_invoice_no'],
                'purchase_order_no' => $data['purchase_order_no'],
                'purchase_order_date' => $data['purchase_order_date'],
                'vendor_id' => $data['vendor_id'],
                'purchase_order_amount' => $data['purchase_order_amount'],
                'requestor' => $data['requestor'] ?? null,
            ]);

            $asset = $record->asset;
            $asset->update([
                'asset_status' => $data['asset_status'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'cost_code' => $data['cost_code'] ?? null,
            ]);

            if ($asset->asset_type === 'hardware') {
                $asset->hardware()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    [
                        'specifications' => $data['specifications'],
                        'serial_number' => $data['serial_number'],
                        'manufacturer' => $data['manufacturer'],
                        'warranty_expiration' => $data['warranty_expiration'],
                        'mac_address' => $data['mac_address'] ?? null,
                        'accessories' => $data['accessories'] ?? null,
                        'pc_name' => $data['pc_name'] ?? null,
                    ]
                );
            }

            if ($asset->asset_type === 'software') {
                $asset->software()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    [
                        'version' => $data['version'],
                        'license_key' => $data['license_key'],
                        'license_type' => $data['license_type'],
                        'pc_name' => $data['pc_name'] ?? null,
                    ]
                );
            }

            if ($asset->asset_type === 'peripherals') {
                $asset->peripherals()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    [
                        'peripherals_type' => $data['peripherals_type'],
                        'specifications' => $data['specifications'],
                        'serial_number' => $data['serial_number'],
                        'manufacturer' => $data['manufacturer'],
                        'warranty_expiration' => $data['warranty_expiration'],
                    ]
                );
            }

            $asset->lifecycle()->update([
                'acquisition_date' => $data['acquisition_date'],
                'retirement_date' => $data['retirement_date'],
            ]);

            return $record;
        });
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
