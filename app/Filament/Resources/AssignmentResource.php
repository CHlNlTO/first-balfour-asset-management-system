<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('asset_id')
                ->label('Asset')
                ->placeholder('Select from existing assets')
                ->relationship('asset', 'id')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} {$record->brand} {$record->model}")
                ->preload()
                ->searchable()
                ->required(),
            Forms\Components\Select::make('employee_id')
                ->label('Employee')
                ->placeholder('Select from registered employees')
                ->relationship('employee', 'id')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id} {$record->name}")
                ->preload()
                ->searchable()
                ->required(),
            Forms\Components\Select::make('assignment_status')
                ->label('Assignment Status')
                ->options(AssignmentStatus::all()->pluck('assignment_status', 'id')->toArray())
                ->default('1')
                ->required()
                ->columnSpan(1), // Span the entire width of the form
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\DatePicker::make('start_date')
                        ->label('Start Date')
                        ->native()
                        ->closeOnDateSelection()
                        ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('End Date')
                        ->native()
                        ->closeOnDateSelection(),
                ])
                ->columns(2) // Specify two columns for the group
                ->columnSpanFull(), // Span the entire width of the form
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.brand')
                    ->label('Brand')
                    ->sortable(),
                Tables\Columns\TextColumn::make('asset.model')
                    ->label('Model')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Assignment Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
