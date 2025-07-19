<?php
// File: app/Filament/Resources/EmpServiceResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpServiceResource\Pages;
use App\Models\CEMREmpService;
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
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class EmpServiceResource extends Resource
{
    protected static ?string $model = CEMREmpService::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Employee Services';

    protected static ?string $navigationGroup = 'Manage Employees';

    protected static ?string $modelLabel = 'Employee Service';

    protected static ?string $pluralModelLabel = 'Employee Services';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Employee Assignment')
                            ->description('Assign employee to organizational structure')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Forms\Components\Select::make('user_id')
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
                                            ->filter()
                                            ->mapWithKeys(function ($employee) {
                                                if (!$employee) return [];
                                                return [$employee->id => "{$employee->id_num} - {$employee->first_name} {$employee->last_name}"];
                                            })
                                            ->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        $employee = CEMREmployee::find($value);
                                        if (!$employee) return null;
                                        return "{$employee->id_num} - {$employee->first_name} {$employee->last_name}";
                                    })
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        if ($state) {
                                            $employee = CEMREmployee::find($state);
                                            if ($employee) {
                                                $set('id_num', $employee->id_num);
                                            }
                                        }
                                    }),

                                Forms\Components\Hidden::make('id_num'),
                            ])
                            ->columns(1),

                        Section::make('Position & Rank')
                            ->description('Define employee position and rank')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Forms\Components\Select::make('rank_id')
                                    ->label('Rank')
                                    ->relationship('rank', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Rank Name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('company_id')
                                            ->label('Company')
                                            ->relationship('company', 'name')
                                            ->required(),
                                    ])
                                    ->placeholder('Select or create rank'),

                                Forms\Components\Select::make('curr_pos_id')
                                    ->label('Current Position')
                                    ->relationship('position', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Position Name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('company_id')
                                            ->label('Company')
                                            ->relationship('company', 'name')
                                            ->required(),
                                    ])
                                    ->placeholder('Select or create position'),

                                Forms\Components\Select::make('emp_stat_id')
                                    ->label('Employment Status')
                                    ->relationship('status', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Status Name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('company_id')
                                            ->label('Company')
                                            ->relationship('company', 'name')
                                            ->required(),
                                    ])
                                    ->placeholder('Select or create status'),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Organizational Structure')
                            ->description('Assign to project and division')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\Select::make('company_id')
                                    ->label('Company')
                                    ->relationship('company', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Company Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter company name'),
                                    ]),

                                Forms\Components\Select::make('division_id')
                                    ->label('Division')
                                    ->options(function (Forms\Get $get) {
                                        $companyId = $get('company_id');
                                        if ($companyId) {
                                            return CEMRDivision::where('company_id', $companyId)
                                                ->pluck('name', 'id');
                                        }
                                        // Show all divisions if no company selected
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
                                            ->maxLength(255)
                                            ->placeholder('Enter division name'),
                                        Forms\Components\Hidden::make('company_id')
                                            ->default(function (Forms\Get $get) {
                                                return $get('company_id');
                                            }),
                                        Forms\Components\Select::make('division_head')
                                            ->label('Division Head')
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
                                            ->placeholder('Select division head'),
                                        Forms\Components\TextInput::make('division_head_name')
                                            ->label('Division Head Name')
                                            ->maxLength(255)
                                            ->placeholder('Enter division head name (if not in employee list)'),
                                    ])
                                    ->createOptionUsing(function (array $data, Forms\Get $get) {
                                        $data['company_id'] = $get('company_id');
                                        $division = CEMRDivision::create($data);
                                        return $division->id;
                                    }),

                                Forms\Components\Select::make('project_id')
                                    ->label('Project')
                                    ->options(function (Forms\Get $get) {
                                        $companyId = $get('company_id');
                                        if ($companyId) {
                                            return CEMRProject::where('company_id', $companyId)
                                                ->pluck('name', 'id');
                                        }
                                        // Show all projects if no company selected
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
                                            ->maxLength(255)
                                            ->placeholder('Enter project name'),
                                        Forms\Components\Hidden::make('company_id')
                                            ->default(function (Forms\Get $get) {
                                                return $get('company_id');
                                            }),
                                    ])
                                    ->createOptionUsing(function (array $data, Forms\Get $get) {
                                        $data['company_id'] = $get('company_id');
                                        $project = CEMRProject::create($data);
                                        return $project->id;
                                    }),

                                Forms\Components\Select::make('cost_code_id')
                                    ->label('Cost Code')
                                    ->options(function (Forms\Get $get) {
                                        $companyId = $get('company_id');
                                        if ($companyId) {
                                            return CEMRCostCode::where('company_id', $companyId)
                                                ->pluck('name', 'id');
                                        }
                                        // Show all cost codes if no company selected
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
                                            ->maxLength(255)
                                            ->placeholder('Enter cost code name'),
                                        Forms\Components\TextInput::make('location')
                                            ->label('Location')
                                            ->maxLength(255)
                                            ->placeholder('Enter location (optional)'),
                                        Forms\Components\Hidden::make('company_id')
                                            ->default(function (Forms\Get $get) {
                                                return $get('company_id');
                                            }),
                                    ])
                                    ->createOptionUsing(function (array $data, Forms\Get $get) {
                                        $data['company_id'] = $get('company_id');
                                        $costCode = CEMRCostCode::create($data);
                                        return $costCode->id;
                                    }),
                            ]),

                        Section::make('Service Details')
                            ->description('Additional service information')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Forms\Components\DatePicker::make('project_hired_date')
                                    ->label('Project Start Date')
                                    ->native(false)
                                    ->displayFormat('Y-m-d')
                                    ->placeholder('Select project start date'),

                                Forms\Components\Textarea::make('comments')
                                    ->label('Comments')
                                    ->rows(4)
                                    ->placeholder('Additional notes or comments'),
                            ]),
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
                Tables\Columns\TextColumn::make('employees.full_name')
                    ->label('Employee')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('employees', function (Builder $query) use ($search) {
                            $searchTerms = explode(' ', $search);
                            $query->where(function ($query) use ($searchTerms) {
                                foreach ($searchTerms as $term) {
                                    $query->where(function ($query) use ($term) {
                                        $query->where('id_num', 'like', "%{$term}%")
                                            ->orWhere('first_name', 'like', "%{$term}%")
                                            ->orWhere('last_name', 'like', "%{$term}%")
                                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                                    });
                                }
                            });
                        });
                    })
                    ->sortable(['first_name', 'last_name'])
                    ->getStateUsing(function (CEMREmpService $record): string {
                        $employee = $record->employees;
                        if (!$employee) return 'No employee assigned';
                        return "{$employee->id_num} - {$employee->full_name}";
                    })
                    ->wrap(),

                Tables\Columns\TextColumn::make('rank.name')
                    ->label('Rank')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->placeholder('Not assigned'),

                Tables\Columns\TextColumn::make('position.name')
                    ->label('Position')
                    ->sortable()
                    ->wrap()
                    ->placeholder('Not assigned'),

                Tables\Columns\TextColumn::make('status.name')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->placeholder('Not assigned'),

                Tables\Columns\TextColumn::make('project.name')
                    ->label('Project')
                    ->sortable()
                    ->wrap()
                    ->placeholder('Not assigned'),

                Tables\Columns\TextColumn::make('division.name')
                    ->label('Division')
                    ->sortable()
                    ->wrap()
                    ->placeholder('Not assigned'),

                Tables\Columns\TextColumn::make('project_hired_date')
                    ->label('Project Start')
                    ->date('M j, Y')
                    ->sortable()
                    ->placeholder('Not set'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('rank_id')
                    ->label('Rank')
                    ->relationship('rank', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('emp_stat_id')
                    ->label('Status')
                    ->relationship('status', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('division_id')
                    ->label('Division')
                    ->relationship('division', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmpServices::route('/'),
            'create' => Pages\CreateEmpService::route('/create'),
            'edit' => Pages\EditEmpService::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
