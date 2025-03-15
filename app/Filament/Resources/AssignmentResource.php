<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Forms\AssignmentForm;
use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Resources\AssignmentResource\Tables\AssignmentTable;
use App\Models\Assignment;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        return AssignmentForm::make($form);
    }


    public static function table(Table $table): Table
    {
        return AssignmentTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'view' => Pages\ViewAssignment::route('/{record}'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
