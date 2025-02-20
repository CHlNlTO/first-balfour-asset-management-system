<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AssignmentResource\Actions\EmployeeTransferAction;
use App\Filament\App\Resources\AssignmentResource\Actions\TableApprovalAction;
use App\Filament\App\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

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
                    ->toggleable(isToggledHiddenByDefault: false),
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
            ->filters([
                Filter::make('show_all')
                    ->label('Show all records')
                    ->query(
                        fn(Builder $query): Builder =>
                        $query->whereNotIn('assignments.id', function (QueryBuilder $subQuery) {
                            return $subQuery
                                ->select(DB::raw('MAX(assignments.id)'))
                                ->from('assignments')
                                ->join('assets', 'assignments.asset_id', '=', 'assets.id')
                                ->where('assignments.employee_id', Auth::user()->id_num);
                        })
                    )
                // TernaryFilter::make('show_all_records')
                //     ->label('Show all records')
                //     ->placeholder('Latest records only')
                //     ->trueLabel('All records')
                //     ->falseLabel('Latest records only')
                //     ->default(false)
                //     ->queries(
                //         true: fn(Builder $query) => $query,
                //         false: fn(Builder $query) => $query
                //             ->whereIn('assignments.id', function (QueryBuilder $subQuery) {
                //                 return $subQuery
                //                     ->select('latest_assignments.id')
                //                     ->from(function (QueryBuilder $innerQuery) {
                //                         return $innerQuery
                //                             ->select('assignments.id')
                //                             ->from('assignments')
                //                             ->whereIn('assignments.id', function (QueryBuilder $idQuery) {
                //                                 return $idQuery
                //                                     ->select(\DB::raw('MAX(assignments.id)'))
                //                                     ->from('assignments')
                //                                     ->join('assets', 'assignments.asset_id', '=', 'assets.id')
                //                                     ->where('assignments.employee_id', Auth::user()->id_num)
                //                                     ->groupBy('assets.tag_number');
                //                             });
                //                     }, 'latest_assignments');
                //             }),
                //     ),
            ])
            ->actions([
                TableApprovalAction::make(),
                EmployeeTransferAction::make(),
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

    // public static function getEloquentQuery(): Builder
    // {
    //     Log::info('User ID Num: ' . Auth::user()->id_num);

    //     $query = parent::getEloquentQuery()
    //         ->where('employee_id', Auth::user()->id_num);

    //     // Add the latest assignments scope by default
    //     return $query->whereIn('assignments.id', function (QueryBuilder $subQuery) {
    //         return $subQuery
    //             ->select(DB::raw('MAX(assignments.id)'))
    //             ->from('assignments')
    //             ->join('assets', 'assignments.asset_id', '=', 'assets.id')
    //             ->where('assignments.employee_id', Auth::user()->id_num)
    //             ->groupBy('assets.tag_number');
    //     })->withGlobalScope('latest_assignments', function (Builder $builder) {
    //         return $builder;
    //     });
    // }
}
