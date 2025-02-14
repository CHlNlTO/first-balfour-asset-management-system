<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LifecycleRenewalResource\Pages;
use App\Filament\Resources\LifecycleRenewalResource\RelationManagers;
use App\Models\LifecycleRenewal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LifecycleRenewalResource extends Resource
{
    protected static ?string $model = LifecycleRenewal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manage Lifecycle';

    protected static ?string $navigationLabel = 'Renewal History';

    protected static ?string $modelLabel = 'Renewal History';

    protected static ?string $slug = 'renewal-histories';

    protected static ?int $navigationSort = 2;

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             //
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
                TextColumn::make('lifecycle_id')
                    ->label('Lifecycle ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('user_id')
                    ->label('User ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('old_retirement_date')
                    ->label('Old Retirement Date')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('new_retirement_date')
                    ->label('New Retirement Date')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('is_automatic')
                    ->label('Is Automatic')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn($record) => $record->is_automatic ? 'Yes' : 'No')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('N/A'),
            ])
            ->filters([])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->groups([
                'lifecycle_id',
                'user_id',
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
            'index' => Pages\ListLifecycleRenewals::route('/'),
            // 'create' => Pages\CreateLifecycleRenewal::route('/create'),
            // 'edit' => Pages\EditLifecycleRenewal::route('/{record}/edit'),
        ];
    }
}
