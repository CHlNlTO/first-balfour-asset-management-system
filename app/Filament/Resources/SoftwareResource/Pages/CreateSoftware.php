<?php

namespace App\Filament\Resources\SoftwareResource\Pages;

use App\Filament\Resources\SoftwareResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Software;

class CreateSoftware extends CreateRecord
{
    protected static string $resource = SoftwareResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        if (isset($data['assets'])) {
            return $this->handleMultipleAssetCreation($data['assets']);
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

        Software::create([
            'asset_id' => $asset->id,
            'version' => $data['version'],
            'license_key' => $data['license_key'],
            'license_type' => $data['license_type'],
        ]);

        return $asset;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
