<?php

// app/Filament/Resources/ProductModelResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductModelResource\Pages;
use App\Models\ProductModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class ProductModelResource extends Resource
{
    protected static ?string $model = ProductModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationGroup = 'Manage Categories';
    protected static ?string $label = 'Model';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Brand Name')
                            ->required()
                            ->maxLength(255)
                            ->unique('brands', 'name')
                            ->validationMessages([
                                'unique' => 'This brand already exists in the system.',
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                    ])
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->placeholder('Optional'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProductModels::route('/'),
            // 'create' => Pages\CreateProductModel::route('/create'),
            'edit' => Pages\EditProductModel::route('/{record}/edit'),
        ];
    }
}
