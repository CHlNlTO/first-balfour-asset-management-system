<?php

namespace App\Filament\Resources\HardwareResource\Pages;

use App\Filament\Resources\HardwareResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;

class CreateHardware extends CreateRecord
{
    protected static string $resource = HardwareResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
