<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Hide the resource if user is not at least Junior Supervisor
    public static function canAccess(): bool
    {
        $user = Auth::user();

        // Find the employee record for the current user
        $employee = Employee::where('id_number', $user->id_num)->first();

        // If employee not found or rank is below Junior Supervisor, hide the resource
        if (!$employee) {
            return false;
        }

        $supervisorRanks = [
            'Senior Manager',
            'Assistant Manager',
            'Senior Supervisor',
            'Supervisor',
            'Junior Supervisor',
        ];

        return in_array($employee->rank_and_file, $supervisorRanks);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('id_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('middle_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('suffix')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('microsoft')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gmail')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rank_and_file')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employment_status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('current_position')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cost_code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project_division_department')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('division')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cbe')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('cost_code')
                    ->options(function () {
                        return Employee::distinct()->pluck('cost_code', 'cost_code')->toArray();
                    }),
                SelectFilter::make('project_division_department')
                    ->options(function () {
                        return Employee::distinct()->pluck('project_division_department', 'project_division_department')->toArray();
                    }),
                SelectFilter::make('division')
                    ->options(function () {
                        return Employee::distinct()->pluck('division', 'division')->toArray();
                    }),
            ])
            ->groups([
                Group::make('cost_code')
                    ->label('Cost Code'),
                Group::make('project_division_department')
                    ->label('Project/Division/Department'),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                // Find the employee record for the current user
                $employee = Employee::where('id_number', $user->id_num)->first();

                if (!$employee) {
                    // If no employee record found, show nothing
                    return $query->whereRaw('1 = 0');
                }

                // Define the rank hierarchy
                // TODO: Add more ranks
                $ranks = [
                    'Senior Manager' => 1,
                    'Assistant Manager' => 2,
                    'Senior Supervisor' => 3,
                    'Supervisor' => 4,
                    'Junior Supervisor' => 5,
                    'Rank & File' => 6,
                    'Skilled Worker' => 7,
                    'Unskilled Worker' => 8
                ];

                // Get current user's rank
                $userRank = $ranks[$employee->rank_and_file] ?? 9;

                // If user is Rank and File or lower, they should only see themselves
                if ($userRank >= 6) {
                    return $query->where('id_number', $user->id_num);
                }

                // Otherwise, filter based on cost_code and lower ranks
                $query->where('cost_code', $employee->cost_code);

                // Get ranks lower than the user's rank
                $lowerRanks = array_filter($ranks, function ($rankValue) use ($userRank) {
                    return $rankValue > $userRank;
                });
                $lowerRankNames = array_keys($lowerRanks);

                // Add the same rank for employees to see others with same rank level
                if ($userRank === 5) { // Junior Supervisor
                    // Junior Supervisors should see lower ranks only
                } elseif ($userRank === 4) { // Supervisor
                    // Supervisors should see Junior Supervisors and lower, but not other Supervisors
                    $lowerRankNames[] = 'Junior Supervisor';
                } elseif ($userRank === 3) { // Senior Supervisor
                    // Senior Supervisors should see Supervisors and lower, but not other Senior Supervisors
                    $lowerRankNames[] = 'Junior Supervisor';
                    $lowerRankNames[] = 'Supervisor';
                } elseif ($userRank === 2) { // Manager
                    // Managers should see Senior Supervisors and lower, but not other Managers
                    $lowerRankNames[] = 'Junior Supervisor';
                    $lowerRankNames[] = 'Supervisor';
                    $lowerRankNames[] = 'Senior Supervisor';
                } elseif ($userRank === 1) { // Senior Manager
                    // Senior Managers should see Managers and lower, but not other Senior Managers
                    $lowerRankNames[] = 'Junior Supervisor';
                    $lowerRankNames[] = 'Supervisor';
                    $lowerRankNames[] = 'Senior Supervisor';
                    $lowerRankNames[] = 'Manager';
                }

                // Include employee's own record
                return $query->where(function ($q) use ($lowerRankNames, $user) {
                    $q->whereIn('rank_and_file', $lowerRankNames);
                });
            })
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'view' => Pages\ViewEmployee::route('/{record}'),
        ];
    }
}
