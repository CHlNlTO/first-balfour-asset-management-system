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
        $excludedStatusIds = AssignmentStatus::whereIn('assignment_status', [
            'Active',
            'Pending Approval',
            'Pending Return',
            'In Transfer',
            'Transferred'
        ])->pluck('id')->toArray();

        $currentDate = now();

        $availableAssets = Asset::whereNotIn('id', function ($query) use ($excludedStatusIds, $currentDate) {
            $query->select('asset_id')
                ->from('assignments')
                ->whereIn('assignment_status', $excludedStatusIds)
                ->where('start_date', '<=', $currentDate)
                ->where(function ($q) use ($currentDate) {
                    $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', $currentDate);
                });
        })->get();

        return Group::make()
            ->schema([
                Section::make('Asset Assignment Details')
                    ->description('Manage asset assignments to employees')
                    ->compact()
                    ->schema([
                        Select::make('asset_id')
                            ->label('Assets')
                            ->placeholder('Search assets')
                            ->options($availableAssets->mapWithKeys(function ($asset) {
                                $label = $asset->tag_number ?? 'No Tag';
                                if ($asset->model?->brand?->name || $asset->model?->name) {
                                    $brand = $asset->model->brand->name ?? 'Unknown Brand';
                                    // For software, only show brand (model = brand name)
                                    if ($asset->asset_type === 'software') {
                                        $label .= ' - ' . $brand;
                                    } else {
                                        // For hardware/peripherals, show brand + model
                                        $model = $asset->model->name ?? 'Unknown Model';
                                        $label .= ' - ' . $brand . ' ' . $model;
                                    }
                                }
                                return [$asset->id => $label];
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
                                    ->label('Receive Date')
                                    ->placeholder('Select receive date')
                                    ->native()
                                    ->default(Carbon::now())
                                    ->closeOnDateSelection()
                                    ->required()
                                    ->inlineLabel(),

                                DatePicker::make('end_date')
                                    ->label('Return Date')
                                    ->placeholder('Select return date')
                                    ->native()
                                    ->closeOnDateSelection()
                                    ->minDate(fn($get) => $get('start_date'))
                                    ->inlineLabel(),
                            ])->columns(2),
                    ]),
            ])
            ->columnSpanFull();
    }
}
