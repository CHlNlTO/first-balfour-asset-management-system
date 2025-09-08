<?php
// File: app/Filament/Resources/EmployeeResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\CEMREmployee;
use App\Models\CEMRRank;
use App\Models\CEMRStatus;
use App\Models\CEMRPosition;
use App\Models\CEMRProject;
use App\Models\CEMRDivision;
use App\Models\CEMRCostCode;
use App\Models\CEMRCompany;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class EmployeeResource extends Resource
{
    protected static ?string $model = CEMREmployee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Employees';

    protected static ?string $navigationGroup = 'Manage Employees';

    protected static ?string $modelLabel = 'Employee';

    protected static ?string $pluralModelLabel = 'Employees';

    protected static ?int $navigationSort = 1;

    public static function getRouteKeyName(): string
    {
        return 'id';
    }

    public static function getRecordRouteKeyName(): string
    {
        return 'id';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Personal Information')
                            ->description('Basic employee identification and personal details')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('id_num')
                                            ->label('Employee ID')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->placeholder('Enter employee ID number'),

                                        Forms\Components\TextInput::make('first_name')
                                            ->label('First Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter first name'),

                                        Forms\Components\TextInput::make('middle_name')
                                            ->label('Middle Name')
                                            ->maxLength(255)
                                            ->placeholder('Enter middle name'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('last_name')
                                            ->label('Last Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter last name'),

                                        Forms\Components\TextInput::make('suffix_name')
                                            ->label('Suffix')
                                            ->maxLength(255)
                                            ->placeholder('Jr., Sr., III, etc.'),
                                    ]),

                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\DatePicker::make('birthdate')
                                            ->label('Date of Birth')
                                            ->native(false)
                                            ->displayFormat('Y-m-d')
                                            ->placeholder('Select birthdate'),

                                        Forms\Components\Select::make('sex')
                                            ->label('Gender')
                                            ->options([
                                                'Male' => 'Male',
                                                'Female' => 'Female',
                                                'Other' => 'Other',
                                            ])
                                            ->placeholder('Select gender'),

                                        Forms\Components\TextInput::make('city')
                                            ->label('City')
                                            ->maxLength(255)
                                            ->placeholder('Enter city'),
                                    ]),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->maxLength(255)
                                    ->placeholder('Enter email address')
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->collapsible(),

                        Section::make('Employment Status')
                            ->description('Current employment status and activity')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('active')
                                            ->label('Active Employee')
                                            ->default(true)
                                            ->helperText('Toggle to activate/deactivate employee'),

                                        Toggle::make('cbe')
                                            ->label('CBE Status')
                                            ->helperText('Competency-Based Evaluation status'),
                                    ]),
                            ])
                            ->columns(1)
                            ->collapsible(),

                        Section::make('Employment Dates')
                            ->description('Important employment milestone dates')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\DatePicker::make('original_hired_date')
                                            ->label('Original Hire Date')
                                            ->native(false)
                                            ->displayFormat('Y-m-d')
                                            ->placeholder('Select hire date'),

                                        Forms\Components\DatePicker::make('final_attrition_date')
                                            ->label('Attrition Date')
                                            ->native(false)
                                            ->displayFormat('Y-m-d')
                                            ->placeholder('Select attrition date (if applicable)'),
                                    ]),
                            ])
                            ->columns(1)
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Organizational Structure')
                            ->description('Employee reporting structure')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\Select::make('manager_id')
                                    ->label('Manager')
                                    ->options(function () {
                                        return CEMREmployee::query()
                                            ->whereNotNull('first_name')
                                            ->whereNotNull('last_name')
                                            ->get()
                                            ->mapWithKeys(function ($employee) {
                                                return [$employee->id => "{$employee->id_num} - {$employee->full_name}"];
                                            });
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Select manager'),

                                Forms\Components\Select::make('supervisor_id')
                                    ->label('Supervisor')
                                    ->options(function () {
                                        return CEMREmployee::query()
                                            ->whereNotNull('first_name')
                                            ->whereNotNull('last_name')
                                            ->get()
                                            ->mapWithKeys(function ($employee) {
                                                return [$employee->id => "{$employee->id_num} - {$employee->full_name}"];
                                            });
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Select supervisor'),
                            ])
                            ->collapsible(),

                        Section::make('Employee Service Assignment')
                            ->description('Create employee service record')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Forms\Components\Toggle::make('create_emp_service')
                                    ->label('Create Employee Service Record')
                                    ->default(false)
                                    ->live()
                                    ->helperText('Enable to create employee service assignment'),

                                Forms\Components\Group::make([
                                    Forms\Components\Select::make('emp_service.company_id')
                                        ->label('Company')
                                        ->options(function () {
                                            return CEMRCompany::pluck('name', 'id');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Company Name')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Enter company name'),
                                        ])
                                        ->createOptionUsing(function (array $data) {
                                            $company = CEMRCompany::create($data);
                                            return $company->id;
                                        })
                                        ->live()
                                        ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                            // Clear dependent fields when company changes
                                            $currentDivision = $get('emp_service.division_id');
                                            $currentProject = $get('emp_service.project_id');
                                            $currentCostCode = $get('emp_service.cost_code_id');

                                            if ($currentDivision && CEMRDivision::find($currentDivision)?->company_id != $state) {
                                                $set('emp_service.division_id', null);
                                            }
                                            if ($currentProject && CEMRProject::find($currentProject)?->company_id != $state) {
                                                $set('emp_service.project_id', null);
                                            }
                                            if ($currentCostCode && CEMRCostCode::find($currentCostCode)?->company_id != $state) {
                                                $set('emp_service.cost_code_id', null);
                                            }
                                        }),

                                    Forms\Components\Select::make('emp_service.rank_id')
                                        ->label('Rank')
                                        ->options(function (Forms\Get $get) {
                                            $companyId = $get('emp_service.company_id');
                                            if ($companyId) {
                                                return CEMRRank::where('company_id', $companyId)
                                                    ->pluck('name', 'id');
                                            }
                                            return CEMRRank::with('company')
                                                ->get()
                                                ->mapWithKeys(function ($rank) {
                                                    return [$rank->id => "{$rank->name} ({$rank->company->name})"];
                                                });
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Rank Name')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\Hidden::make('company_id')
                                                ->default(function (Forms\Get $get) {
                                                    return $get('emp_service.company_id');
                                                }),
                                        ])
                                        ->createOptionUsing(function (array $data, Forms\Get $get) {
                                            $data['company_id'] = $get('emp_service.company_id');
                                            $rank = CEMRRank::create($data);
                                            return $rank->id;
                                        }),

                                    Forms\Components\Select::make('emp_service.curr_pos_id')
                                        ->label('Position')
                                        ->options(function (Forms\Get $get) {
                                            $companyId = $get('emp_service.company_id');
                                            if ($companyId) {
                                                return CEMRPosition::where('company_id', $companyId)
                                                    ->pluck('name', 'id');
                                            }
                                            return CEMRPosition::with('company')
                                                ->get()
                                                ->mapWithKeys(function ($position) {
                                                    return [$position->id => "{$position->name} ({$position->company->name})"];
                                                });
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Position Name')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\Hidden::make('company_id')
                                                ->default(function (Forms\Get $get) {
                                                    return $get('emp_service.company_id');
                                                }),
                                        ])
                                        ->createOptionUsing(function (array $data, Forms\Get $get) {
                                            $data['company_id'] = $get('emp_service.company_id');
                                            $position = CEMRPosition::create($data);
                                            return $position->id;
                                        }),

                                    Forms\Components\Select::make('emp_service.emp_stat_id')
                                        ->label('Employment Status')
                                        ->options(function (Forms\Get $get) {
                                            $companyId = $get('emp_service.company_id');
                                            if ($companyId) {
                                                return CEMRStatus::where('company_id', $companyId)
                                                    ->pluck('name', 'id');
                                            }
                                            return CEMRStatus::with('company')
                                                ->get()
                                                ->mapWithKeys(function ($status) {
                                                    return [$status->id => "{$status->name} ({$status->company->name})"];
                                                });
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Status Name')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\Hidden::make('company_id')
                                                ->default(function (Forms\Get $get) {
                                                    return $get('emp_service.company_id');
                                                }),
                                        ])
                                        ->createOptionUsing(function (array $data, Forms\Get $get) {
                                            $data['company_id'] = $get('emp_service.company_id');
                                            $status = CEMRStatus::create($data);
                                            return $status->id;
                                        }),

                                    Forms\Components\Select::make('emp_service.division_id')
                                        ->label('Division')
                                        ->options(function (Forms\Get $get) {
                                            $companyId = $get('emp_service.company_id');
                                            if ($companyId) {
                                                return CEMRDivision::where('company_id', $companyId)
                                                    ->pluck('name', 'id');
                                            }
                                            return CEMRDivision::with('company')
                                                ->get()
                                                ->mapWithKeys(function ($division) {
                                                    return [$division->id => "{$division->name} ({$division->company->name})"];
                                                });
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Division Name')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\Hidden::make('company_id')
                                                ->default(function (Forms\Get $get) {
                                                    return $get('emp_service.company_id');
                                                }),
                                        ])
                                        ->createOptionUsing(function (array $data, Forms\Get $get) {
                                            $data['company_id'] = $get('emp_service.company_id');
                                            $division = CEMRDivision::create($data);
                                            return $division->id;
                                        })
                                        ->live()
                                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                                            if ($state) {
                                                $division = CEMRDivision::find($state);
                                                if ($division) {
                                                    $set('emp_service.company_id', $division->company_id);
                                                }
                                            }
                                        }),

                                    Forms\Components\Select::make('emp_service.project_id')
                                        ->label('Project')
                                        ->options(function (Forms\Get $get) {
                                            $companyId = $get('emp_service.company_id');
                                            if ($companyId) {
                                                return CEMRProject::where('company_id', $companyId)
                                                    ->pluck('name', 'id');
                                            }
                                            return CEMRProject::with('company')
                                                ->get()
                                                ->mapWithKeys(function ($project) {
                                                    return [$project->id => "{$project->name} ({$project->company->name})"];
                                                });
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Project Name')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\Hidden::make('company_id')
                                                ->default(function (Forms\Get $get) {
                                                    return $get('emp_service.company_id');
                                                }),
                                        ])
                                        ->createOptionUsing(function (array $data, Forms\Get $get) {
                                            $data['company_id'] = $get('emp_service.company_id');
                                            $project = CEMRProject::create($data);
                                            return $project->id;
                                        })
                                        ->live()
                                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                                            if ($state) {
                                                $project = CEMRProject::find($state);
                                                if ($project) {
                                                    $set('emp_service.company_id', $project->company_id);
                                                }
                                            }
                                        }),

                                    Forms\Components\Select::make('emp_service.cost_code_id')
                                        ->label('Cost Code')
                                        ->options(function (Forms\Get $get) {
                                            $companyId = $get('emp_service.company_id');
                                            if ($companyId) {
                                                return CEMRCostCode::where('company_id', $companyId)
                                                    ->pluck('name', 'id');
                                            }
                                            return CEMRCostCode::with('company')
                                                ->get()
                                                ->mapWithKeys(function ($costCode) {
                                                    return [$costCode->id => "{$costCode->name} ({$costCode->company->name})"];
                                                });
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Cost Code Name')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('location')
                                                ->label('Location')
                                                ->maxLength(255)
                                                ->placeholder('Enter location (optional)'),
                                            Forms\Components\Hidden::make('company_id')
                                                ->default(function (Forms\Get $get) {
                                                    return $get('emp_service.company_id');
                                                }),
                                        ])
                                        ->createOptionUsing(function (array $data, Forms\Get $get) {
                                            $data['company_id'] = $get('emp_service.company_id');
                                            $costCode = CEMRCostCode::create($data);
                                            return $costCode->id;
                                        })
                                        ->live()
                                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                                            if ($state) {
                                                $costCode = CEMRCostCode::find($state);
                                                if ($costCode) {
                                                    $set('emp_service.company_id', $costCode->company_id);
                                                }
                                            }
                                        }),

                                    Forms\Components\DatePicker::make('emp_service.project_hired_date')
                                        ->label('Project Start Date')
                                        ->native(false)
                                        ->displayFormat('Y-m-d'),

                                    Forms\Components\Textarea::make('emp_service.comments')
                                        ->label('Comments')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ])
                                    ->visible(fn (Forms\Get $get): bool => $get('create_emp_service'))
                                    ->columns(2),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns([
                'lg' => 3
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_num')
                    ->label('Employee ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Employee ID copied!')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'last_name', 'middle_name'])
                    ->sortable(['first_name', 'last_name'])
                    ->weight('medium')
                    ->wrap(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->icon('heroicon-m-envelope')
                    ->placeholder('No email'),

                Tables\Columns\TextColumn::make('empService.rank.name')
                    ->label('Rank')
                    ->placeholder('Not assigned')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('empService.position.name')
                    ->label('Position')
                    ->placeholder('Not assigned')
                    ->wrap(),

                Tables\Columns\TextColumn::make('empService.project.name')
                    ->label('Project')
                    ->placeholder('Not assigned')
                    ->wrap(),

                Tables\Columns\TextColumn::make('empService.division.name')
                    ->label('Division')
                    ->placeholder('Not assigned')
                    ->wrap(),

                Tables\Columns\IconColumn::make('active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('cbe')
                    ->label('CBE')
                    ->boolean()
                    ->trueIcon('heroicon-o-academic-cap')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('original_hired_date')
                    ->label('Hire Date')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),

                SelectFilter::make('cbe')
                    ->label('CBE Status')
                    ->options([
                        '1' => 'CBE Qualified',
                        '0' => 'Not CBE Qualified',
                    ]),

                SelectFilter::make('sex')
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ]),

                Filter::make('has_email')
                    ->label('Has Email')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email'))
                    ->toggle(),

                Filter::make('hired_this_year')
                    ->label('Hired This Year')
                    ->query(fn (Builder $query): Builder => $query->whereYear('original_hired_date', now()->year))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye'),

                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['active' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['active' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->searchOnBlur()
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
