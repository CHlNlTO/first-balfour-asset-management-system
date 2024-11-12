<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAssignments extends ListRecords
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Active' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('assignment_status', '1')),
            'Inactive' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('assignment_status', '2')),
            'Pending Approval' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('assignment_status', '3')),
            'Pending Return' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('assignment_status', '4')),
        ];
    }
}
