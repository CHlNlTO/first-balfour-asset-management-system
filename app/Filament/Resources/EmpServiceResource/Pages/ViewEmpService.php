<?php
// File: app/Filament/Resources/EmpServiceResource/Pages/ViewEmpService.php

namespace App\Filament\Resources\EmpServiceResource\Pages;

use App\Filament\Resources\EmpServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmpService extends ViewRecord
{
    protected static string $resource = EmpServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Service')
                ->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()
                ->label('Delete Service')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }
}
