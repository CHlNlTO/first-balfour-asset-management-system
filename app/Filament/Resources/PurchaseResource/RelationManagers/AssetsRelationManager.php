<?php

namespace App\Filament\Resources\PurchaseResource\RelationManagers;

use App\Models\Asset;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AssetsRelationManager extends RelationManager
{

    protected static ?string $model = Purchase::class;

    protected static string $relationship = 'asset';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable(true)
                    ->url(fn(Asset $record): string => route('filament.admin.resources.assets.view', ['record' => $record->id])),
                Tables\Columns\TextColumn::make('model.brand.name')
                    ->label('Asset Brand')
                    ->sortable()
                    ->searchable(true)
                    ->url(fn(Asset $record): string => route('filament.admin.resources.assets.view', ['record' => $record->id])),
                Tables\Columns\TextColumn::make('model.name')
                    ->label('Asset Model')
                    ->sortable()
                    ->searchable(true)
                    ->url(fn(Asset $record): string => route('filament.admin.resources.assets.view', ['record' => $record->id])),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
