<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostCodeResource\Pages;
use App\Filament\Resources\CostCodeResource\RelationManagers;
use App\Models\CostCode;
use App\Models\DepartmentProject;
use App\Models\Division;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CostCodeResource extends Resource
{
    protected static ?string $model = CostCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Manage Organization';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Cost Code')
                    ->required()
                    ->inlineLabel()
                    ->placeholder('COST001')
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->inlineLabel()
                    ->placeholder('Industrial Projects Cost Code')
                    ->columnSpanFull(),
                Select::make('department_project_code')
                    ->relationship('departmentProject', 'name', fn($query) => $query->orderBy('name'))
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->label('Department/Project Code')
                            ->required()
                            ->inlineLabel()
                            ->unique('departments_projects', 'code')
                            ->validationMessages([
                                'unique' => 'This department/project code already exists in the system.',
                            ])
                            ->placeholder('DEP001')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->inlineLabel()
                            ->placeholder('Industrial Projects Department')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('division_code')
                            ->relationship('division', 'name', fn($query) => $query->orderBy('name'))
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('code')
                                    ->label('Division Code')
                                    ->required()
                                    ->inlineLabel()
                                    ->maxLength(255)
                                    ->unique('divisions', 'code')
                                    ->validationMessages([
                                        'unique' => 'This division code already exists in the system.',
                                    ])
                                    ->placeholder('DIV001')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->inlineLabel()
                                    ->placeholder('Industrial Projects Division')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->nullable()
                                    ->inlineLabel()
                                    ->placeholder('This division is responsible for all industrial projects.')
                                    ->columnSpanFull(),
                            ])
                            ->getSearchResultsUsing(
                                fn(string $search) => Division::where('name', 'like', "%{$search}%")
                                    ->limit(50)
                                    ->pluck('name', 'code')
                            )
                            ->getOptionLabelUsing(fn($value): ?string => Division::where('code', $value)->first()?->name)
                            ->createOptionUsing(function (array $data) {
                                $division = Division::create($data);
                                return $division->code;
                            })
                            ->searchable()
                            ->preload()
                            ->inlineLabel()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->nullable()
                            ->inlineLabel()
                            ->placeholder('This department is responsible for all industrial projects.')
                            ->columnSpanFull(),
                    ])
                    ->getSearchResultsUsing(
                        fn(string $search) => DepartmentProject::where('name', 'like', "%{$search}%")
                            ->limit(50)
                            ->pluck('name', 'code')
                    )
                    ->getOptionLabelUsing(fn($value): ?string => DepartmentProject::where('code', $value)->first()?->name)
                    ->createOptionUsing(function (array $data) {
                        $departmentProject = DepartmentProject::create($data);
                        return $departmentProject->code;
                    })
                    ->searchable()
                    ->preload()
                    ->inlineLabel()
                    ->columnSpanFull(),
                TextInput::make('description')
                    ->label('Description')
                    ->nullable()
                    ->inlineLabel()
                    ->placeholder('This cost code is responsible for all industrial projects.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('code')
                    ->label('Cost Code')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('department_project_code')
                    ->label('Department/Project Code')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('departmentProject.division_code')
                    ->label('Division Code')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCostCodes::route('/'),
            // 'create' => Pages\CreateCostCode::route('/create'),
            'edit' => Pages\EditCostCode::route('/{record}/edit'),
        ];
    }
}
