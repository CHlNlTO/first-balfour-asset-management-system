<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareResource\Pages;
use App\Models\Software;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Repeater;

class SoftwareResource extends Resource
{
    protected static ?string $model = Software::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Manage Assets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('assets')
                    ->schema([
                        Forms\Components\Fieldset::make('Asset Details')
                            ->schema([
                                Forms\Components\TextInput::make('asset_type')
                                    ->label('Asset Type')
                                    ->default('software')
                                    ->disabled(),
                                Forms\Components\Select::make('asset_status')
                                    ->label('Asset Status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'under repair' => 'Under Repair',
                                        'in transfer' => 'In Transfer',
                                        'disposed' => 'Disposed',
                                        'lost' => 'Lost',
                                        'stolen' => 'Stolen'
                                    ])
                                    ->required()
                                    ->autofocus()
                                    ->default('active'),
                                Forms\Components\TextInput::make('brand')->label('Brand')->required(),
                                Forms\Components\TextInput::make('model')->label('Model')->required(),
                            ]),
                        Forms\Components\Fieldset::make('Software Details')
                            ->schema([
                                Forms\Components\TextInput::make('version')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('license_key')
                                    ->required()
                                    ->label('License Key')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('license_type')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->createItemButtonLabel('Add Software Asset')
                    ->columnSpanFull()
                    ->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_id')->numeric()->sortable()->searchable(),
                TextColumn::make('asset.brand')->searchable()->label('Brand'),
                TextColumn::make('asset.model')->searchable()->label('Model'),
                TextColumn::make('version')->searchable(),
                TextColumn::make('license_key')->searchable(),
                TextColumn::make('license_type')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
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
            'index' => Pages\ListSoftware::route('/'),
            'create' => Pages\CreateSoftware::route('/create'),
            'edit' => Pages\EditSoftware::route('/{record}/edit'),
        ];
    }
}
