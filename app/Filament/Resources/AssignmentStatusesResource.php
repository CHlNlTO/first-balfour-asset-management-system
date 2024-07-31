<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentStatusesResource\Pages;
use App\Models\AssignmentStatus;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentStatusesResource extends Resource
{
    protected static ?string $model = AssignmentStatus::class;

    protected static ?string $navigationGroup = 'Manage Statuses';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('assignment_status')
                ->required()
                ->label("Assignment Status"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->label('ID')->sortable()->searchable(),
            TextColumn::make('assignment_status')->label('Assignment Status')->sortable()->searchable(),
            TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: false)->searchable(),
            TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: false)->searchable(),
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
            'index' => Pages\ListAssignmentStatuses::route('/'),
            'create' => Pages\CreateAssignmentStatuses::route('/create'),
            'edit' => Pages\EditAssignmentStatuses::route('/{record}/edit'),
        ];
    }
}
