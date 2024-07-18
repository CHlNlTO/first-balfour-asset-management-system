<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Assuming `assets` is the key containing multiple asset data
        if (isset($data['assets'])) {
            return $this->handleMultipleAssetCreation($data['assets']);
        }

        // If not handling multiple, proceed as single record creation
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

        return end($createdAssets); // Return the last created asset for redirecting
    }

    protected function handleSingleAssetCreation(array $data): Asset
    {
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
        ]);

        if ($data['asset_type'] === 'hardware') {
            Hardware::create([
                'asset_id' => $asset->id,
                'specifications' => $data['specifications'],
                'serial_number' => $data['serial_number'],
                'manufacturer' => $data['manufacturer'],
                'warranty_expiration' => $data['warranty_expiration'],
            ]);
        }

        if ($data['asset_type'] === 'software') {
            Software::create([
                'asset_id' => $asset->id,
                'version' => $data['version'],
                'license_key' => $data['license_key'],
                'license_type' => $data['license_type'],
            ]);
        }

        return $asset;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
