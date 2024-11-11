<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class DepartmentFilterWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.department-filter-widget';

    public $selectedDepartment = null;

    protected static ?int $sort = 1;

    public function mount()
    {
        $this->selectedDepartment = Cache::get('selected_department');
        $this->form->fill([
            'selectedDepartment' => $this->selectedDepartment,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('selectedDepartment')
                ->label('Filter by Department/Project')
                ->options(Asset::distinct()->pluck('department_project_code', 'department_project_code'))
                ->placeholder('All Departments/Projects')
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->selectedDepartment = $state;
                    Cache::put('selected_department', $state);
                    $this->emitTo('app.filament.widgets.asset-stats-overview', 'departmentFilterUpdated');
                    $this->emitTo('app.filament.widgets.asset-costs', 'departmentFilterUpdated');
                }),
        ];
    }

    public function getFormStatePath(): string
    {
        return 'data';
    }
}