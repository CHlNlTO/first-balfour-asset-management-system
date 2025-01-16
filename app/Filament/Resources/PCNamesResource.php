<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PCNamesResource\Pages;
use App\Filament\Resources\PCNamesResource\RelationManagers;
use App\Models\PCName;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PCNamesResource extends Resource
{
    protected static ?string $model = PCName::class;

    protected static ?string $navigationGroup = 'Manage Categories';

    protected static ?string $modelLabel = 'PC Name';

    protected static ?string $navigationLabel = 'PC Names';

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('DESKTOP-ABC123'),
                TextInput::make('description')
                    ->nullable()
                    ->placeholder('Main Office Desktop'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('M, d Y'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->date('M, d Y'),
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
            'index' => Pages\ListPCNames::route('/'),
            // 'create' => Pages\CreatePCNames::route('/create'),
            'edit' => Pages\EditPCNames::route('/{record}/edit'),
        ];
    }
}
