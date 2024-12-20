<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Actions\ApproveSaleAction;
use App\Filament\Resources\AssignmentResource\Actions\ApproveSaleActionInOptionToBuy;
use App\Filament\Resources\OptionToBuyResource\Pages;
use App\Models\OptionToBuy;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionToBuyResource extends Resource
{
    protected static ?string $model = OptionToBuy::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Option to Buy';

    protected static ?string $navigationGroup = 'Manage Transactions';

    protected static ?string $modelLabel = 'Option to Buy';

    protected static ?string $pluralModelLabel = 'Option to Buy';

    protected static ?string $slug = "option-to-buy";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('assignment_id')
                    ->label('Assignment ID')
                    ->options(Assignment::all()->mapWithKeys(function ($assignment) {
                        return [$assignment->id => $assignment->id . ' - ' . $assignment->employee->first_name . ' ' . $assignment->employee->last_name . ' - ' . $assignment->asset->brand . ' ' . $assignment->asset->model];
                    })->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('asset_cost')
                    ->required()
                    ->prefix('₱')
                    ->numeric()
                    ->label('Asset Cost'),
                Forms\Components\Select::make('option_to_buy_status')
                    ->label('Status')
                    ->options(AssignmentStatus::all()->pluck('assignment_status', 'id'))
                    ->default('10')
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('assignment.id')
                    ->label('Assignment ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee')
                    ->getStateUsing(function (OptionToBuy $record): string {
                        $employee = $record->assignment->employee->first_name . ' ' . $record->assignment->employee->last_name;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn(OptionToBuy $record): string => route('filament.admin.resources.employees.view', ['record' => $record->assignment->employee->id_num])),
                Tables\Columns\TextColumn::make('asset')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('assignment', function (Builder $query) use ($search) {
                            $query->whereHas('asset', function (Builder $query) use ($search) {
                                $query->whereRaw("CONCAT(assets.brand, ' ', assets.model) LIKE ?", ["%{$search}%"]);
                            });
                        });
                    })
                    ->getStateUsing(function (OptionToBuy $record): string {
                        $asset = $record->assignment->asset->brand . ' ' . $record->assignment->asset->model;
                        return $asset ? $asset : 'N/A';
                    })
                    ->url(fn(OptionToBuy $record): string => route('filament.admin.resources.assets.view', ['record' => $record->assignment->asset_id])),
                Tables\Columns\TextColumn::make('asset_cost')
                    ->money('php')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status.assignment_status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        "Active" => "success",
                        "Pending Approval" => "pending",
                        "Pending Return" => "warning",
                        "In Transfer" => "primary",
                        "Transferred" => "success",
                        "Declined" => "danger",
                        'Unknown' => 'gray',
                        'Asset Sold' => 'success',
                        'Option to Buy' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('employee_id')
                    ->label("Filter by Employee")
                    ->searchable()
                    ->indicator('Employee')
                    ->options(function (string $search = null) {
                        $query = CEMREmployee::on('central_employeedb');

                        if ($search) {
                            $query->where(function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                        }

                        return $query->get()
                            ->mapWithKeys(function ($employee) {
                                $fullName = trim("{$employee->first_name} {$employee->last_name}");
                                return [$employee->id_num => $fullName];
                            })
                            ->toArray();
                    })
                    ->query(function (Builder $query, $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('assignment', function (Builder $query) use ($data) {
                                $query->where('employee_id', $data['value']);
                            });
                        }
                    })
                    ->preload(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                ApproveSaleActionInOptionToBuy::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListOptionToBuys::route('/'),
            'create' => Pages\CreateOptionToBuy::route('/create'),
            'view' => Pages\ViewOptionToBuy::route('/{record}'),
            'edit' => Pages\EditOptionToBuy::route('/{record}/edit'),
        ];
    }
}
