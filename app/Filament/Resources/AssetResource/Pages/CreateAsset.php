<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Peripheral;
use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Lifecycle;
use Illuminate\Support\Facades\Log;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        if (isset($data['Asset Information'])) {
            return $this->handleMultipleAssetCreation($data['Asset Information']);
        }

        return $this->handleSingleAssetCreation($data);
    }

    protected function handleMultipleAssetCreation(array $assetsData)
    {
        $createdAssets = [];

        DB::transaction(function () use ($assetsData, &$createdAssets) {
            foreach ($assetsData as $assetData) {
                $createdAssets[] = $this->createSingleAsset($assetData);
            }
        });

        return end($createdAssets);
    }

    protected function handleSingleAssetCreation(array $data): Asset
    {
        Log::info("To Be Saved Data:", $data);
        return DB::transaction(function () use ($data) {
            return $this->createSingleAsset($data);
        });
    }

    protected function createSingleAsset(array $data): Asset
    {
        $asset = Asset::create([
            'asset_type' => $data['asset_type'],
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'department_project_code' => $data['department_project_code'] ?? null,
        ]);

        Lifecycle::create([
            'asset_id' => $asset->id,
            'acquisition_date' => $data['acquisition_date'],
            'retirement_date' => $data['retirement_date'] ?? null,
        ]);

        $vendorId = $this->handleVendor($data);

        Purchase::create([
            'asset_id' => $asset->id,
            'purchase_order_no' => $data['purchase_order_no'],
            'sales_invoice_no' => $data['sales_invoice_no'],
            'purchase_order_date' => $data['purchase_order_date'],
            'purchase_order_amount' => $data['purchase_order_amount'],
            'requestor' => $data['requestor'] ?? null,
            'vendor_id' => $vendorId,
        ]);

        if ($data['asset_type'] === 'hardware') {
            Hardware::create([
                'asset_id' => $asset->id,
                'hardware_type' => $data['hardware_type'] ?? null,
                'serial_number' => $data['serial_number'] ?? null,
                'specifications' => $data['specifications'] ?? null,
                'manufacturer' => $data['manufacturer'] ?? null,
                'warranty_expiration' => $data['warranty_expiration'] ?? null,
                'mac_address' => $data['mac_address'] ?? null,
                'accessories' => $data['accessories'] ?? null,
                'pc_name' => $data['pc_name'] ?? null,
            ]);
        } elseif ($data['asset_type'] === 'software') {
            Software::create([
                'asset_id' => $asset->id,
                'version' => $data['version'] ?? null,
                'license_key' => $data['license_key'] ?? null,
                'software_type' => $data['software_type'] ?? null,
                'license_type' => $data['license_type'] ?? null,
                'pc_name' => $data['pc_name'] ?? null,
            ]);
        } else if ($data['asset_type'] === 'peripherals') {
            Peripheral::create([
                'asset_id' => $asset->id,
                'peripherals_type' => $data['peripherals_type'] ?? null,
                'specifications' => $data['specifications'] ?? null,
                'serial_number' => $data['serial_number'] ?? null,
                'manufacturer' => $data['manufacturer'] ?? null,
                'warranty_expiration' => $data['warranty_expiration'] ?? null,
            ]);
        }

        return $asset;
    }

    protected function handleVendor(array $data): int
    {
        if ($data['vendor_option'] === 'new') {
            $vendor = Vendor::create([
                'name' => $data['vendor']['name'],
                'address_1' => $data['vendor']['address_1'],
                'address_2' => $data['vendor']['address_2'] ?? null,
                'city' => $data['vendor']['city'],
                'tel_no_1' => $data['vendor']['tel_no_1'],
                'tel_no_2' => $data['vendor']['tel_no_2'] ?? null,
                'contact_person' => $data['vendor']['contact_person'],
                'mobile_number' => $data['vendor']['mobile_number'],
                'email' => $data['vendor']['email'],
                'url' => $data['vendor']['url'] ?? null,
                'remarks' => $data['vendor']['remarks'] ?? null,
            ]);
            return $vendor->id;
        } else {
            return $data['vendor_id'];
        }
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
