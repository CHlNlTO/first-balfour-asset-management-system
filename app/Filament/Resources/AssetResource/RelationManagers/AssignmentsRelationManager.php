<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->placeholder('Select from registered employees')
                    ->relationship('employee', 'id_num')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->id_num} {$record->first_name} {$record->last_name}")
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
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Assignment ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.id_num')
                    ->label('Employee ID')
                    ->sortable()
                    ->searchable()
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id])),
                Tables\Columns\TextColumn::make('employee')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Assignment $record): string {
                        $employee = $record->employee->first_name . ' ' . $record->employee->last_name;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id])),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Assignment Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        "Active" => "success",
                        "Pending Approval" => "pending",
                        "Pending Return" => "warning",
                        "In Transfer" => "primary",
                        "Transferred" => "success",
                        "Declined" => "danger",
                        'Unknown' => 'gray',
                        'Asset Sold' => 'success',
                        'Option to Buy' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('assignments.id', 'desc');
    }
}
