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
        // Get all assignment statuses from the database
        $assignmentStatuses = \App\Models\AssignmentStatus::all();

        // Define the tabs we want to show (retain specific ones)
        $retainedTabs = ['All', 'Active', 'Inactive', 'Defective', 'Pending Return', 'Asset Sold'];

        $tabs = [
            'All' => Tab::make(),
        ];

        // Build tabs dynamically for retained statuses
        foreach ($retainedTabs as $tabName) {
            if ($tabName === 'All') {
                continue; // Already added above
            }

            // Find the matching assignment status in the database
            $status = $assignmentStatuses->first(function ($status) use ($tabName) {
                return $status->assignment_status === $tabName;
            });

            if ($status) {
                $tabs[$tabName] = Tab::make()
                    ->modifyQueryUsing(
                        fn(Builder $query) => $query
                            ->whereHas('status', fn($q) => $q->where('assignment_status', $status->assignment_status))
                    );
            }
        }

        return $tabs;
    }
}
