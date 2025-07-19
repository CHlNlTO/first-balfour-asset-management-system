<?php
// File: app/Filament/Resources/EmpServiceResource/Pages/ListEmpServices.php

namespace App\Filament\Resources\EmpServiceResource\Pages;

use App\Filament\Resources\EmpServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmpServices extends ListRecords
{
    protected static string $resource = EmpServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Employee Service')
                ->icon('heroicon-o-plus'),
        ];
    }
}
