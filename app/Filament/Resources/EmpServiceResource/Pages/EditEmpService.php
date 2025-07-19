<?php
// File: app/Filament/Resources/EmpServiceResource/Pages/EditEmpService.php

namespace App\Filament\Resources\EmpServiceResource\Pages;

use App\Filament\Resources\EmpServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditEmpService extends EditRecord
{
    protected static string $resource = EmpServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Service')
                ->icon('heroicon-o-eye'),
            Actions\DeleteAction::make()
                ->label('Delete Service')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee service updated')
            ->body('The employee service assignment has been updated successfully.');
    }
}
