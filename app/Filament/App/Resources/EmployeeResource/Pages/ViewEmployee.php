<?php

namespace App\Filament\App\Resources\EmployeeResource\Pages;

use App\Filament\App\Resources\EmployeeResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Employee Information')
                    ->description('Basic identification and personal details')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('id_number')
                                    ->label('ID Number')
                                    ->inlineLabel()
                                    ->placeholder('Employee ID')
                                    ->disabled(),
                                TextInput::make('full_name')
                                    ->label('Full Name')
                                    ->inlineLabel()
                                    ->placeholder('Employee Full Name')
                                    ->disabled(),
                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->inlineLabel()
                                    ->placeholder('First Name')
                                    ->disabled(),
                                TextInput::make('middle_name')
                                    ->label('Middle Name')
                                    ->inlineLabel()
                                    ->placeholder('Middle Name')
                                    ->disabled(),
                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->inlineLabel()
                                    ->placeholder('Last Name')
                                    ->disabled(),
                                TextInput::make('suffix')
                                    ->label('Suffix')
                                    ->inlineLabel()
                                    ->placeholder('e.g., Jr., Sr., III')
                                    ->disabled(),
                            ]),
                    ]),

                Section::make('Contact Information')
                    ->description('Employee contact details')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('microsoft')
                                    ->label('Microsoft Email')
                                    ->email()
                                    ->inlineLabel()
                                    ->placeholder('Microsoft Email Address')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextInput::make('gmail')
                                    ->label('Gmail Address')
                                    ->email()
                                    ->inlineLabel()
                                    ->placeholder('Gmail Address')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                    ]),

                Section::make('Employment Details')
                    ->description('Position and status information')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('rank_and_file')
                                    ->label('Rank')
                                    ->inlineLabel()
                                    ->placeholder('Employee Rank')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextInput::make('employment_status')
                                    ->label('Status')
                                    ->inlineLabel()
                                    ->placeholder('Employment Status')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextInput::make('current_position')
                                    ->label('Position')
                                    ->inlineLabel()
                                    ->placeholder('Current Position')
                                    ->disabled()
                                    ->columnSpan(2),

                            ]),
                    ]),

                Section::make('Project Assignment')
                    ->description('Project and department details')
                    ->icon('heroicon-o-building-office')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('cost_code')
                                    ->label('Cost Code')
                                    ->inlineLabel()
                                    ->placeholder('Cost Code')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextInput::make('division')
                                    ->label('Division')
                                    ->inlineLabel()
                                    ->placeholder('Division')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextInput::make('cbe')
                                    ->label('CBE')
                                    ->inlineLabel()
                                    ->placeholder('CBE Status')
                                    ->disabled()
                                    ->columnSpan(2),
                            ]),
                        Grid::make(4)
                            ->schema([
                                Textarea::make('project_division_department')
                                    ->label('Project/Division/Department')
                                    ->inlineLabel()
                                    ->placeholder('Project, Division, or Department Details')
                                    ->disabled()
                                    ->rows(2)
                                    ->columnSpan(2),
                            ]),
                    ]),

                // Section::make('System Information')
                //     ->description('Record timestamps')
                //     ->icon('heroicon-o-clock')
                //     ->collapsed()
                //     ->schema([
                //         Grid::make(2)
                //             ->schema([
                //                 DateTimePicker::make('created_at')
                //                     ->label('Created At')
                //                     ->inlineLabel()
                //                     ->displayFormat('M d, Y')
                //                     ->disabled(),
                //                 DateTimePicker::make('updated_at')
                //                     ->label('Last Updated')
                //                     ->inlineLabel()
                //                     ->displayFormat('M d, Y')
                //                     ->disabled(),
                //             ]),
                //     ]),
            ]);
    }
}
