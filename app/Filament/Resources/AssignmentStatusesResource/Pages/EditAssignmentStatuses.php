<?php

namespace App\Filament\Resources\AssignmentStatusesResource\Pages;

use App\Filament\Resources\AssignmentStatusesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssignmentStatuses extends EditRecord
{
    protected static string $resource = AssignmentStatusesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
