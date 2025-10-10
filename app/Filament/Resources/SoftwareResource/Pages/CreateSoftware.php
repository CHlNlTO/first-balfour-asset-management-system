<?php

namespace App\Filament\Resources\SoftwareResource\Pages;

use App\Filament\Resources\SoftwareResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Software;
use App\Models\Purchase;
use App\Models\Vendor;

class CreateSoftware extends CreateRecord
{
    protected static string $resource = SoftwareResource::class;

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

    protected function handleSingleAssetCreation(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->createSingleAsset($data);
        });
    }

    protected function createSingleAsset(array $data)
    {
        $asset = Asset::create([
            'asset_type' => 'software',
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
        ]);

        $software = Software::create([
            'asset_id' => $asset->id,
            'version' => $data['version'],
            'license_key' => $data['license_key'],
            'software_type' => $data['software_type'] ?? null,
            'license_type' => $data['license_type'] ?? null,
        ]);

        if ($data['add_purchase_information'] === 'yes') {
            $vendorId = $this->handleVendor($data);

            Purchase::create([
                'asset_id' => $asset->id,
                'receipt_no' => $data['receipt_no'],
                'purchase_date' => $data['purchase_date'],
                'vendor_id' => $vendorId,
                'purchase_cost' => $data['asset_cost'],
            ]);
        }

        return $software;
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
