<?php

namespace App\Filament\Resources\AssignmentResource\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use App\Models\Asset;
use App\Models\AssignmentStatus;
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
                                return [$asset->id => $asset->id . ' - ' . $asset->brand . ' ' . $asset->model];
                            })->toArray())
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->inlineLabel(),

                        Select::make('employee_id')
                            ->label('Employee')
                            ->placeholder('Search by ID or name')
                            ->relationship('employee', 'id_num')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->id_num} {$record->first_name} {$record->last_name}")
                            ->searchable(['id_num', 'first_name', 'last_name'])
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
            ->columnSpan(['lg' => 2]);
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
            ->columnSpan(['lg' => 1]);
    }
}
