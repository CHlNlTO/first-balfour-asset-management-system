<?php

namespace App\Filament\Resources\DepartmentProjectResource\Pages;

use App\Filament\Resources\DepartmentProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartmentProject extends EditRecord
{
    protected static string $resource = DepartmentProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
