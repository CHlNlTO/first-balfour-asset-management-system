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
            Actions\Action::make('export_report')
                ->label('Export Assignments')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(route('export.assignment-report'))
                ->openUrlInNewTab()
                ->extraAttributes([
                    'class' => 'bg-green-600 hover:bg-green-700'
                ])
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Active' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'Active'))
                ),
            'In Transfer' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'In Transfer'))
                ),
            'Inactive' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'Inactive'))
                ),
            'Pending Approval' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'Pending Approval'))
                ),
            'Pending Return' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'Pending Return'))
                ),
            'Option To Buy' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'Option to Buy'))
                ),
            'Asset Sold' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('status', fn($q) => $q->where('assignment_status', 'Asset Sold'))
                ),
        ];
    }
}
