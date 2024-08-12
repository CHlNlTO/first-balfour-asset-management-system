<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Models\Asset;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\OptionToBuy;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Filament\Tables\Actions\ActionGroup;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asset_id')
                    ->label('Assets')
                    ->placeholder('Select from existing assets')
                    ->options(Asset::all()->mapWithKeys(function ($asset) {
                        return [$asset->id => $asset->id . ' - ' . $asset->brand . ' ' . $asset->model];
                    })->toArray())
                    ->multiple()
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->placeholder('Select from registered employees')
                    ->relationship('employee', 'id_num')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id_num} {$record->first_name} {$record->last_name}")
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('assignment_status')
                    ->label('Assignment Status')
                    ->options(AssignmentStatus::all()->pluck('assignment_status', 'id')->toArray())
                    ->default('3')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->native()
                            ->closeOnDateSelection()
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->native()
                            ->closeOnDateSelection()
                            ->minDate(fn ($get) => $get('start_date')),
                    ])->reactive()
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->orWhere('assignments.id', 'like', "%{$search}%");
                }),
                Tables\Columns\TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable()
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('asset.brand')
                    ->label('Asset')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Assignment $record): string {
                        $asset = $record->asset;
                        return $asset ? " {$asset->brand} {$asset->model}" : 'N/A';
                    })
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Assignment $record): string {
                        $employee = $record->employee->id_num;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num])),
                Tables\Columns\TextColumn::make('employee')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Assignment $record): string {
                        $employee = $record->employee->first_name . ' ' . $record->employee->last_name;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn (Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num])),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
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
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->label('Remarks')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('No remarks'),
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
                SelectFilter::make('assignment_status')
                    ->label("Filter by Assignment Status")
                    ->searchable()
                    ->indicator('Status')
                    ->options(AssignmentStatus::pluck('assignment_status', 'id')->toArray()),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Action::make('Transfer')
                        ->form([
                            Hidden::make('asset_id')
                                ->default(fn ($record) => $record->asset_id)
                                ->required(),
                            TextInput::make('asset_display')
                                ->label('Assets')
                                ->default(fn ($record) => "{$record->asset->id} - {$record->asset->brand} {$record->asset->model}")
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('from_employee_id')
                                ->default(fn ($record) => $record->employee->id_num)
                                ->required(),
                            TextInput::make('from_employee_display')
                                ->label('From Employee')
                                ->default(fn ($record) => "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}")
                                ->disabled()
                                ->dehydrated(false),
                            Forms\Components\Select::make('employee_id')
                                ->label('To Employee')
                                ->placeholder('Select from registered employees')
                                ->relationship('employee', 'id')
                                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id_num} - {$record->first_name} {$record->last_name}")
                                ->searchable()
                                ->required(),
                            Hidden::make('assignment_status')
                                ->default('3')
                                ->required(),
                            TextInput::make('assignment_status_display')
                                ->label('Assignment Status')
                                ->default('Pending Approval')
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('old_start_date')
                                ->default(fn ($record) => Carbon::parse($record->start_date)->format('Y-m-d')),
                            Hidden::make('old_end_date')
                                ->default(fn ($record) => Carbon::parse($record->end_date)->format('Y-m-d')),
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\DatePicker::make('start_date')
                                        ->label('Start Date')
                                        ->native()
                                        ->closeOnDateSelection()
                                        ->required(),
                                    Forms\Components\DatePicker::make('end_date')
                                        ->label('End Date')
                                        ->native()
                                        ->closeOnDateSelection(),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                        ])
                        ->action(function (Assignment $record, array $data) {
                            DB::beginTransaction();

                            try {
                                Log::info("Data received in Transfer action:", $data);

                                $record->update([
                                    'asset_id' => $data['asset_id'] ?? $record->asset_id,
                                    'employee_id' => $data['from_employee_id'],
                                    'assignment_status' => 2,
                                    'start_date' => $data['old_start_date'],
                                ]);

                                Assignment::create([
                                    'asset_id' => $data['asset_id'] ?? $record->asset_id,
                                    'employee_id' => $data['employee_id'],
                                    'assignment_status' => $data['assignment_status'],
                                    'start_date' => $data['start_date'],
                                    'end_date' => $data['end_date'],
                                ]);

                                DB::commit();

                                Notification::make()
                                    ->title('Asset transferred successfully')
                                    ->success()
                                    ->send();

                            } catch (\Exception $e) {
                                DB::rollBack();
                                Log::error("Error in Transfer action: " . $e->getMessage());

                                Notification::make()
                                    ->title('Error transferring asset')
                                    ->body('An error occurred while transferring the asset. Please try again.')
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->icon('heroicon-o-arrows-right-left')
                        ->requiresConfirmation()
                        ->modalHeading('Transfer Asset')
                        ->modalButton('Transfer')
                        ->successNotificationTitle('Asset Transferred.'),
                    Action::make('Option to Buy')
                        ->form([
                            Hidden::make('id')
                                ->default(fn ($record) => $record->id)
                                ->required(),
                            Hidden::make('asset_id')
                                ->default(fn ($record) => $record->asset_id)
                                ->required(),
                            TextInput::make('asset_display')
                                ->label('Assets')
                                ->default(fn ($record) => "{$record->asset->id} - {$record->asset->brand} {$record->asset->model}")
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('from_employee_id')
                                ->default(fn ($record) => $record->employee->id_num)
                                ->required(),
                            TextInput::make('from_employee_display')
                                ->label('Sell to Employee')
                                ->default(fn ($record) => "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}")
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('assignment_status')
                                ->default('10')
                                ->required(),
                            TextInput::make('assignment_status_display')
                                ->label('Assignment Status')
                                ->default('Option to Buy')
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('old_start_date')
                                ->default(fn ($record) => Carbon::parse($record->start_date)->format('Y-m-d')),
                            Hidden::make('old_end_date')
                                ->default(fn ($record) => Carbon::parse($record->end_date)->format('Y-m-d')),
                            TextInput::make('asset_cost')
                                ->label('Asset Cost')
                                ->prefix('₱')
                                ->numeric()
                                ->required(),
                        ])
                        ->action(function (Assignment $record, array $data) {
                            DB::beginTransaction();

                            try {
                                Log::info("Data received in Option to Buy action:", $data);

                                $record->update([
                                    'asset_id' => $data['asset_id'] ?? $record->asset_id,
                                    'employee_id' => $data['from_employee_id'],
                                    'assignment_status' => 10,
                                    'start_date' => $data['old_start_date'],
                                ]);

                                OptionToBuy::create([
                                    'assignment_id' => $record->id,
                                    'option_to_buy_status' => 10,
                                    'asset_cost' => $data['asset_cost'],
                                ]);

                                DB::commit();

                                Notification::make()
                                    ->title('Option In Progress')
                                    ->success()
                                    ->send();

                            } catch (\Exception $e) {
                                DB::rollBack();
                                Log::error("Error in Transfer action: " . $e->getMessage());

                                Notification::make()
                                    ->title('Error transferring asset')
                                    ->body('An error occurred while transferring the asset. Please try again.')
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->icon('heroicon-o-banknotes')
                        ->requiresConfirmation()
                        ->modalHeading('Option to Buy Asset')
                        ->modalButton('Accept Option')
                        ->successNotificationTitle('Asset Transferred.'),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->color('primary')
                ->tooltip('Actions'),
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
