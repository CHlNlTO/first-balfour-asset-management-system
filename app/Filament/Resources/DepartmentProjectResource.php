<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentProjectResource\Pages;
use App\Filament\Resources\DepartmentProjectResource\RelationManagers;
use App\Models\DepartmentProject;
use App\Models\Division;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentProjectResource extends Resource
{
    protected static ?string $model = DepartmentProject::class;
    protected static ?string $modellabel = 'Department/Project';
    protected static ?string $pluralModelLabel = 'Departments/Projects';
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Manage Organization';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Department/Project Code')
                    ->required()
                    ->inlineLabel()
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('code')
                    ->label('Department Code')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('division_code')
                    ->label('Division Code')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListDepartmentProjects::route('/'),
            // 'create' => Pages\CreateDepartmentProject::route('/create'),
            'edit' => Pages\EditDepartmentProject::route('/{record}/edit'),
        ];
    }
}
