<?php

namespace App\Filament\Resources\LifecycleRenewalResource\Pages;

use App\Filament\Resources\LifecycleRenewalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLifecycleRenewal extends EditRecord
{
    protected static string $resource = LifecycleRenewalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
