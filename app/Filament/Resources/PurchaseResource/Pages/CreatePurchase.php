<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Peripheral;
use App\Models\Lifecycle;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Extract general purchase information
        $purchaseOrderNo = $data['purchase_order_no'];
        $salesInvoiceNo = $data['sales_invoice_no'];
        $purchaseOrderDate = $data['purchase_order_date'];
        $purchaseRequestor = $data['requestor'];

        // Handle vendor information
        $vendorId = $this->handleVendor($data);

        // Handle asset information
        $assetsData = $data['Asset Information'];

        DB::transaction(function () use ($purchaseOrderNo, $salesInvoiceNo, $purchaseOrderDate, $purchaseRequestor, $vendorId, $assetsData) {
            foreach ($assetsData as $assetData) {
                if ($assetData['asset_option'] === 'new') {
                    $asset = $this->createAsset($assetData);
                    $assetId = $asset->id;
                } else {
                    $assetId = $assetData['asset_id'];
                }

                Purchase::create([
                    'asset_id' => $assetId,
                    'purchase_order_no' => $purchaseOrderNo,
                    'sales_invoice_no' => $salesInvoiceNo,
                    'purchase_order_date' => $purchaseOrderDate,
                    'vendor_id' => $vendorId,
                    'purchase_order_amount' => $assetData['purchase_order_amount'],
                    'requestor' => $purchaseRequestor,
                ]);
            }
        });

        return new Purchase();
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
        $asset = Asset::create([
            'asset_type' => $data['asset_type'],
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'cost_code' => $data['cost_code'] ?? null,
        ]);

        Lifecycle::create([
            'asset_id' => $asset->id,
            'acquisition_date' => $data['acquisition_date'],
            'retirement_date' => $data['retirement_date'] ?? null,
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

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
