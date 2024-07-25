<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Extract general purchase information
        $receiptNo = $data['receipt_no'];
        $purchaseDate = $data['purchase_date'];

        // Handle vendor information
        $vendorId = $this->handleVendor($data);

        // Handle asset information
        $assetsData = $data['Asset Information'];

        DB::transaction(function () use ($receiptNo, $purchaseDate, $vendorId, $assetsData) {
            foreach ($assetsData as $assetData) {
                if ($assetData['asset_option'] === 'new') {
                    $asset = $this->createAsset($assetData);
                    $assetId = $asset->id;
                } else {
                    $assetId = $assetData['asset_id'];
                }

                Purchase::create([
                    'asset_id' => $assetId,
                    'receipt_no' => $receiptNo,
                    'purchase_date' => $purchaseDate,
                    'vendor_id' => $vendorId,
                    'purchase_cost' => $assetData['asset_cost'],
                ]);
            }
        });

        return new Purchase(); // Return a new instance to satisfy the return type
    }

    protected function handleVendor(array $data): int
    {
        if ($data['vendor_option'] === 'new') {
            $vendor = Vendor::create([
                'name' => $data['vendor']['name'],
                'address_1' => $data['vendor']['address_1'],
                'address_2' => $data['vendor']['address_2'],
                'city' => $data['vendor']['city'],
                'tel_no_1' => $data['vendor']['tel_no_1'],
                'tel_no_2' => $data['vendor']['tel_no_2'],
                'contact_person' => $data['vendor']['contact_person'],
                'mobile_number' => $data['vendor']['mobile_number'],
                'email' => $data['vendor']['email'],
                'url' => $data['vendor']['url'],
                'remarks' => $data['vendor']['remarks'],
            ]);
            return $vendor->id;
        } else {
            return $data['vendor_id'];
        }
    }

    protected function createAsset(array $data): Asset
    {
        Log::info('Creating asset with data:', $data);

        $asset = Asset::create([
            'asset_type' => $data['asset_type'],
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
        ]);

        Log::info('Asset created:', ['id' => $asset->id, 'type' => $asset->asset_type]);

        if ($data['asset_type'] === 'hardware') {
            Log::info('Attempting to create hardware record:', $data);

            try {
                $hardware = Hardware::create([
                    'asset_id' => $asset->id,
                    'specifications' => $data['specifications'] ?? '',
                    'serial_number' => $data['serial_number'] ?? '',
                    'manufacturer' => $data['manufacturer'] ?? '',
                    'warranty_expiration' => $data['warranty_expiration'] ?? null,
                ]);

                Log::info('Hardware record created:', ['id' => $hardware->id]);
            } catch (\Exception $e) {
                Log::error('Error creating hardware record:', ['error' => $e->getMessage()]);
            }
        } elseif ($data['asset_type'] === 'software') {
            Log::info('Attempting to create software record:', $data);

            try {
                $software = Software::create([
                    'asset_id' => $asset->id,
                    'version' => $data['version'] ?? '',
                    'license_key' => $data['license_key'] ?? '',
                    'license_type' => $data['license_type'] ?? '',
                ]);

                Log::info('Software record created:', ['id' => $software->id]);
            } catch (\Exception $e) {
                Log::error('Error creating software record:', ['error' => $e->getMessage()]);
            }
        }

        return $asset;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
