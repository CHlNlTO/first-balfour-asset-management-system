<?php

namespace App\Filament\App\Resources\EmployeeResource\RelationManagers;

use App\Models\AssignmentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $title = 'Employee Assets & Assignments';

    // We're using a custom relationship, so we need to define how it works
    protected function getTableQuery(): Builder
    {
        return \App\Models\Assignment::query()
            ->where('employee_id', $this->ownerRecord->id_number);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Assignment Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('asset.tag_number')
                                    ->label('Tag Number')
                                    ->disabled(),
                                Forms\Components\TextInput::make('asset.asset')
                                    ->label('Asset')
                                    ->disabled(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('asset.asset_type')
                                    ->label('Asset Type')
                                    ->disabled(),
                                Forms\Components\TextInput::make('status.assignment_status')
                                    ->label('Assignment Status')
                                    ->disabled(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->displayFormat('M d, Y')
                                    ->disabled(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->displayFormat('M d, Y')
                                    ->disabled(),
                            ]),
                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->disabled()
                            ->rows(3),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.tag_number')
                    ->label('Tag Number')
                    ->sortable()
                    ->placeholder('N/A')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asset.asset')
                    ->label('Asset')
                    ->sortable()
                    ->placeholder('N/A')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asset.asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('status.assignment_status')
                    ->label('Status')
                    ->sortable()
                    ->placeholder('N/A')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        "Active" => "success",
                        "Pending Approval" => "pending",
                        "Pending Return" => "warning",
                        "In Transfer" => "primary",
                        "Transferred" => "gray",
                        "Declined" => "danger",
                        'Unknown' => 'gray',
                        'Asset Sold' => 'success',
                        'Option to Buy' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('remarks')
                    ->label('Remarks')
                    ->limit(30)
                    ->placeholder('N/A')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // You can add filters if needed
            ])
            ->headerActions([
                // No header actions since this is view-only
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions needed for view-only
            ])
            ->defaultSort('created_at', 'desc');
    }
}
