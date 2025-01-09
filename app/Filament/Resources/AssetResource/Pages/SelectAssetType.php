<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;

class SelectAssetType extends Page
{
    protected static string $resource = AssetResource::class;

    protected static string $view = 'filament.pages.select-asset-type';

    public function getTitle(): string
    {
        return 'Select Asset Type';
    }
}
