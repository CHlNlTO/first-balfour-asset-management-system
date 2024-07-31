<?php

namespace App\Filament\Resources\AssignmentStatusesResource\Pages;

use App\Filament\Resources\AssignmentStatusesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAssignmentStatuses extends CreateRecord
{
    protected static string $resource = AssignmentStatusesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
