<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Hardware;
use App\Models\HardwareSoftware;
use App\Models\Software;
use App\Models\Peripheral;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Log;

class EditAsset extends EditRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info('Initial Record Data:', $this->record->toArray());

        // Common data mutation for all asset types
        $data = $this->mutateCommonData($data);

        // Asset type specific mutations
        switch ($this->record->asset_type) {
            case 'hardware':
                $data = $this->mutateHardwareData($data);
                break;
            case 'software':
                $data = $this->mutateSoftwareData($data);
                break;
            case 'peripherals':
                $data = $this->mutatePeripheralsData($data);
                break;
        }

        // Purchase data mutation
        $data = $this->mutatePurchaseData($data);

        Log::info('Final Mutated Data:', $data);
        return $data;
    }

    protected function mutateCommonData(array $data): array
    {
        return array_merge($data, [
            'asset_type' => $this->record->asset_type ?? null,
            'asset_status' => $this->record->asset_status ?? null,
            'brand' => $this->record->model->brand->name ?? null,
            'brand_display' => $this->record->model->brand->name ?? null,
            'model' => $this->record->model->id ?? null,
            'cost_code' => $this->record->costCost->name ?? null,
            'tag_number' => $this->record->tag_number ?? null,
            'acquisition_date' => $this->record->lifecycle?->acquisition_date ?? null,
            'retirement_date' => $this->record->lifecycle?->retirement_date ?? null,
            'vendor_id' => $this->record->purchases()->first()->vendor_id ?? null,
            'purchase_order_no' => $this->record->purchases()->first()->purchase_order_no ?? null,
            'sales_invoice_no' => $this->record->purchases()->first()->sales_invoice_no ?? null,
            'purchase_order_date' => $this->record->lifecycle?->acquisition_date ?? null,
            'purchase_order_amount' => $this->record->purchases()->first()->purchase_order_amount ?? null,
            'requestor' => $this->record->purchases()->first()->requestor ?? null,
        ]);
    }

    protected function mutateHardwareData(array $data): array
    {
        $hardware = $this->record->hardware;

        if ($hardware) {
            $data['hardware_type'] = $hardware->hardware_type;
            $data['serial_number'] = $hardware->serial_number;
            $data['manufacturer'] = $hardware->manufacturer;
            $data['specifications'] = $hardware->specifications;
            $data['accessories'] = $hardware->accessories;
            $data['mac_address'] = $hardware->mac_address;
            $data['pc_name'] = $hardware->pc_name_id;
            $data['warranty_expiration'] = $this->record->lifecycle?->retirement_date ?? null;
        }

        return $data;
    }

    protected function mutateSoftwareData(array $data): array
    {
        $software = $this->record->software;

        if ($software) {
            $data['software_type'] = $software->software_type;
            $data['license_type'] = $software->license_type;
            $data['version'] = $software->version;
            $data['license_key'] = $software->license_key;
            $data['pc_name'] = $software->pc_name_id;
        }

        return $data;
    }

    protected function mutatePeripheralsData(array $data): array
    {
        $peripheral = $this->record->peripherals;

        if ($peripheral) {
            $data['peripherals_type'] = $peripheral->peripherals_type;
            $data['manufacturer'] = $peripheral->manufacturer;
            $data['specifications'] = $peripheral->specifications;
            $data['warranty_expiration'] = $this->record->lifecycle?->retirement_date ?? null;
        }

        return $data;
    }

    protected function mutatePurchaseData(array $data): array
    {
        $purchase = $this->record->purchase;

        if ($purchase) {
            $data['purchase_order_no'] = $purchase->purchase_order_no;
            $data['sales_invoice_no'] = $purchase->sales_invoice_no;
            $data['purchase_order_date'] = $this->record->lifecycle?->acquisition_date;
            $data['purchase_order_amount'] = $purchase->purchase_order_amount;
            $data['requestor'] = $purchase->requestor;
        }

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        Log::info('Update Data Before Processing:', $data);

        return DB::transaction(function () use ($record, $data) {
            // Update common asset fields
            $record->update([
                'asset_status' => $data['asset_status'],
                'model_id' => $data['model'],
                'cost_code' => $data['cost_code'] ?? null,
                'tag_number' => $data['tag_number'] ?? null,
            ]);

            // Update type-specific data
            switch ($record->asset_type) {
                case 'hardware':
                    $this->updateHardwareData($record, $data);
                    break;
                case 'software':
                    $this->updateSoftwareData($record, $data);
                    break;
                case 'peripherals':
                    $this->updatePeripheralsData($record, $data);
                    break;
            }

            // Update lifecycle data
            $record->lifecycle()->updateOrCreate(
                ['asset_id' => $record->id],
                [
                    'acquisition_date' => $data['acquisition_date'],
                    'retirement_date' => $data['retirement_date'] ?? null,
                ]
            );

            // Update purchase data
            $record->purchases()->updateOrCreate(
                ['asset_id' => $record->id],
                [
                    'purchase_order_no' => $data['purchase_order_no'],
                    'sales_invoice_no' => $data['sales_invoice_no'],
                    'purchase_order_date' => $data['acquisition_date'],
                    'purchase_order_amount' => $data['purchase_order_amount'],
                    'vendor_id' => $data['vendor_id'],
                    'requestor' => $data['requestor'] ?? null,
                ]
            );

            return $record;
        });
    }

    protected function updateHardwareData($record, array $data): void
    {
        $record->hardware()->updateOrCreate(
            ['asset_id' => $record->id],
            [
                'hardware_type' => $data['hardware_type'] ?? null,
                'serial_number' => $data['serial_number'] ?? null,
                'specifications' => $data['specifications'] ?? null,
                'manufacturer' => $data['manufacturer'] ?? null,
                'mac_address' => $data['mac_address'] ?? null,
                'accessories' => $data['accessories'] ?? null,
                'pc_name_id' => $data['pc_name'] ?? null,
                'warranty_expiration' => $data['retirement_date'] ?? null,
            ]
        );

        // Update software relationships if provided
        if (!empty($data['software'])) {
            $softwareRecords = Software::whereIn('asset_id', $data['software'])->pluck('asset_id');

            if ($softwareRecords->isNotEmpty()) {
                foreach ($softwareRecords as $softwareAssetId) {
                    HardwareSoftware::create([
                        'hardware_asset_id' => $record->id,
                        'software_asset_id' => $softwareAssetId
                    ]);
                }
            }
        }
    }

    protected function updateSoftwareData($record, array $data): void
    {
        $record->software()->updateOrCreate(
            ['asset_id' => $record->id],
            [
                'software_type' => $data['software_type'] ?? null,
                'license_type' => $data['license_type'] ?? null,
                'version' => $data['version'] ?? null,
                'license_key' => $data['license_key'] ?? null,
                'pc_name_id' => $data['pc_name'] ?? null,
            ]
        );

        // Attach software if selected
        if (!empty($data['hardware'])) {
            Log::info("Attaching software to hardware", $data['hardware']);

            // Get the hardware records
            $hardwareRecords = Hardware::whereIn('asset_id', $data['hardware'])
                ->pluck('asset_id');

            if ($hardwareRecords->isNotEmpty()) {
                // Get the software record we just created
                $software = Software::where('asset_id', $record->id)->first();

                // Attach hardware to software
                $software->hardware()->attach(
                    $hardwareRecords->mapWithKeys(function ($hardwareAssetId) use ($record) {
                        return [$hardwareAssetId => [
                            'hardware_asset_id' => $hardwareAssetId,
                            'software_asset_id' => $record->id
                        ]];
                    })->all()
                );
            }
        }
    }

    protected function updatePeripheralsData($record, array $data): void
    {
        $record->peripherals()->updateOrCreate(
            ['asset_id' => $record->id],
            [
                'peripherals_type' => $data['peripherals_type'],
                'specifications' => $data['specifications'],
                'manufacturer' => $data['manufacturer'],
                'warranty_expiration' => $data['retirement_date'] ?? null,
            ]
        );
    }

    public function form(Form $form): Form
    {
        switch ($this->record->asset_type) {
            case 'hardware':
                return (new CreateHardwareAsset())->form($form);
            case 'software':
                return (new CreateSoftwareAsset())->form($form);
            default:
                return (new CreatePeripheralsAsset())->form($form);
        }
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
