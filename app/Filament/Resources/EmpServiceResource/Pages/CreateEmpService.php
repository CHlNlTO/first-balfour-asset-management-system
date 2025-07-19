<?php
// File: app/Filament/Resources/EmpServiceResource/Pages/CreateEmpService.php

namespace App\Filament\Resources\EmpServiceResource\Pages;

use App\Filament\Resources\EmpServiceResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateEmpService extends CreateRecord
{
    protected static string $resource = EmpServiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee service created')
            ->body('The employee service assignment has been created successfully.');
    }
}
