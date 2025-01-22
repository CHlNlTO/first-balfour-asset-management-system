<?php

namespace App\Filament\Resources\DepartmentProjectResource\Pages;

use App\Filament\Resources\DepartmentProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartmentProjects extends ListRecords
{
    protected static string $resource = DepartmentProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
