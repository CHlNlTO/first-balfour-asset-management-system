<?php

namespace App\Filament\Resources\AssignmentStatusesResource\Pages;

use App\Filament\Resources\AssignmentStatusesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignmentStatuses extends ListRecords
{
    protected static string $resource = AssignmentStatusesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
