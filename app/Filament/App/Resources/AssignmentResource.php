<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static bool $shouldRegisterNavigation = false;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('asset_id')
                    ->label('Asset ID')
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('asset.tag_number')
                    ->label('Tag Number')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('asset.asset')
                    ->label('Asset')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('asset.asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('status.assignment_status')
                    ->label('Assignment Status')
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
                    ->date()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('remarks')
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('created_at', 'desc');
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
            'view' => Pages\ViewAssignment::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        Log::info('User ID Num: ' . Auth::user()->id_num);

        return parent::getEloquentQuery()
            ->where('employee_id', Auth::user()->id_num);
    }
}
