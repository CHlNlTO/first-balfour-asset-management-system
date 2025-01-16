<?php

namespace App\Filament\Resources\AssignmentResource\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use App\Models\Asset;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use App\Models\Employee;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Carbon\Carbon;

class AssignmentForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                static::getAssetAssignmentSection(),
                static::getAssignmentPeriodSection(),
            ])
            ->columns(['lg' => 3])
            ->inlineLabel();
    }

    protected static function getAssetAssignmentSection(): Group
    {
        return Group::make()
            ->schema([
                Section::make('Asset Assignment Details')
                    ->description('Manage asset assignments to employees')
                    ->compact()
                    ->schema([
                        Select::make('asset_id')
                            ->label('Assets')
                            ->placeholder('Search assets')
                            ->options(Asset::all()->mapWithKeys(function ($asset) {
                                return [$asset->id => $asset->tag_number . ' - ' . $asset->model->brand->name . ' ' . $asset->model->name];
                            })->toArray())
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->inlineLabel(),

                        Select::make('employee_id')
                            ->label('Employee')
                            ->placeholder('Search by ID or name')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return CEMREmployee::query()
                                    ->where(function ($query) use ($search) {
                                        $searchTerms = explode(' ', $search);

                                        foreach ($searchTerms as $term) {
                                            $query->where(function ($query) use ($term) {
                                                $query->where('id_num', 'like', "%{$term}%")
                                                    ->orWhere('first_name', 'like', "%{$term}%")
                                                    ->orWhere('last_name', 'like', "%{$term}%")
                                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                                            });
                                        }
                                    })
                                    ->limit(50)
                                    ->get()
                                    ->filter() // Remove any null values
                                    ->mapWithKeys(function ($employee) {
                                        // Add null check
                                        if (!$employee) return [];
                                        return [$employee->id_num => "{$employee->id_num} {$employee->first_name} {$employee->last_name}"];
                                    })
                                    ->toArray();
                            })
                            ->getOptionLabelUsing(function ($value) {
                                // Add more robust error checking
                                $employee = CEMREmployee::find($value);
                                if (!$employee) return null;

                                return "{$employee->id_num} {$employee->first_name} {$employee->last_name}";
                            })
                            ->required()
                            ->inlineLabel(),

                        Select::make('assignment_status')
                            ->label('Status')
                            ->options(AssignmentStatus::all()->pluck('assignment_status', 'id')->toArray())
                            ->default('3')
                            ->required()
                            ->inlineLabel()
                            ->placeholder('Select status'),
                    ])->columns(2)
            ])
            ->columnSpanFull();
    }

    protected static function getAssignmentPeriodSection(): Group
    {
        return Group::make()
            ->schema([
                Section::make('Assignment Period')
                    ->description('Specify the duration of the asset assignment')
                    ->compact()
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->placeholder('Select start date')
                                    ->native()
                                    ->default(Carbon::now())
                                    ->closeOnDateSelection()
                                    ->required()
                                    ->inlineLabel(),

                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->placeholder('Select end date')
                                    ->native()
                                    ->closeOnDateSelection()
                                    ->minDate(fn($get) => $get('start_date'))
                                    ->inlineLabel(),
                            ]),
                    ]),
            ])
            ->columnSpanFull();
    }
}
