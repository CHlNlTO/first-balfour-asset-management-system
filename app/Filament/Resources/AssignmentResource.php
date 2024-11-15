<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Models\Asset;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use App\Models\OptionToBuy;
use App\Models\Transfer;
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
use Filament\Support\Enums\Alignment;
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
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->id_num} {$record->first_name} {$record->last_name}")
                    ->searchable(['id_num', 'first_name', 'last_name'])
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
                            ->default(Carbon::now())
                            ->closeOnDateSelection()
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->native()
                            ->closeOnDateSelection()
                            ->minDate(fn($get) => $get('start_date')),
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
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                Tables\Columns\TextColumn::make('asset')
                    ->label('Asset Name')
                    ->getStateUsing(function (Assignment $record): string {
                        return "{$record->asset->brand} {$record->asset->model}";
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('asset', function (Builder $query) use ($search) {
                            $query->where('brand', 'like', "%{$search}%")
                                ->orWhere('model', 'like', "%{$search}%");
                        });
                    })
                    ->placeholder('N/A')
                    ->url(fn(Assignment $record): string => $record->asset ? route('filament.admin.resources.assets.view', ['record' => $record->asset_id]) : '#'),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Assignment $record): string {
                        $employee = $record->employee->id_num;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn(Assignment $record): string => route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num])),
                Tables\Columns\TextColumn::make('employee')
                    ->label('Employee Name')
                    ->getStateUsing(function (Assignment $record): string {
                        return $record->employee ? "{$record->employee->first_name} {$record->employee->last_name}" : 'N/A';
                    })
                    ->url(fn(Assignment $record): string => $record->employee ? route('filament.admin.resources.employees.view', ['record' => $record->employee->id_num]) : '#'),
                Tables\Columns\TextColumn::make('assignment_status')
                    ->label('Status')
                    ->getStateUsing(function (Assignment $record): string {
                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                    })
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
                SelectFilter::make('employee_id')
                    ->label("Filter by Employee Name")
                    ->searchable()
                    ->indicator('Employee')
                    ->options(
                        CEMREmployee::on('central_employeedb')
                            ->get()
                            ->mapWithKeys(function ($employee) {
                                $fullName = trim("{$employee->first_name} {$employee->last_name}");
                                return [$employee->id_num => $fullName];
                            })
                            ->toArray()
                    ),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Action::make('Transfer')
                        ->visible(fn(Assignment $record): bool => $record->assignment_status == AssignmentStatus::where('assignment_status', 'Active')->first()->id)
                        ->form([
                            Hidden::make('asset_id')
                                ->default(fn($record) => $record->asset_id)
                                ->required(),
                            TextInput::make('asset_display')
                                ->label('Assets')
                                ->default(fn($record) => "{$record->asset->id} - {$record->asset->brand} {$record->asset->model}")
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('from_employee_id')
                                ->default(fn($record) => $record->employee->id_num)
                                ->required(),
                            TextInput::make('from_employee_display')
                                ->label('From Employee')
                                ->default(fn($record) => "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}")
                                ->disabled()
                                ->dehydrated(false),
                            Forms\Components\Select::make('employee_id')
                                ->label('To Employee')
                                ->placeholder('Select from registered employees')
                                ->relationship('employee', 'id_num')
                                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->id_num} - {$record->first_name} {$record->last_name}")
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
                                ->default(fn($record) => Carbon::parse($record->start_date)->format('Y-m-d')),
                            Hidden::make('old_end_date')
                                ->default(fn($record) => Carbon::parse($record->end_date)->format('Y-m-d')),
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
                                    ->title('Transfer Initiated')
                                    ->body('The asset is now for approval by the receiving employee.')
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
                    Tables\Actions\Action::make('manageTransfer')
                        ->label('Manage Transfer')
                        ->icon('heroicon-o-cog')
                        ->color('primary')
                        ->visible(fn(Assignment $record): bool => $record->assignment_status == AssignmentStatus::where('assignment_status', 'In Transfer')->first()->id)
                        ->modalIcon('heroicon-o-cog')
                        ->modalHeading('Manage Transfer')
                        ->modalDescription(function (Assignment $record) {
                            $transfer = Transfer::where('assignment_id', $record->id)
                                ->orderBy('id', 'desc')
                                ->first();
                            Log::info("Transfer record:", $transfer->toArray());
                            $toEmployee = CEMREmployee::where('id_num', $transfer->to_employee)->first();
                            return "Transfer {$record->asset->brand} {$record->asset->model} to {$toEmployee->first_name} {$toEmployee->last_name}?";
                        })
                        ->modalAlignment(Alignment::Center)
                        ->modalFooterActions([
                            Tables\Actions\Action::make('approve')
                                ->label('Approve')
                                ->color('success')
                                ->requiresConfirmation()
                                ->modalHeading('Approve Transfer')
                                ->modalDescription('Are you sure you want to approve this transfer?')
                                ->form([
                                    Forms\Components\DatePicker::make('start_date')
                                        ->label('Start Date')
                                        ->required(),
                                    Forms\Components\DatePicker::make('end_date')
                                        ->label('End Date')
                                        ->after('start_date'),
                                ])
                                ->modalSubmitActionLabel('Yes, approve')
                                ->action(function (Assignment $record, array $data) {
                                    // Find the transfer record
                                    $transfer = Transfer::where('assignment_id', $record->id)->firstOrFail();

                                    // Create new assignment for the receiving employee
                                    $pendingApprovalStatusId = AssignmentStatus::where('assignment_status', 'Pending Approval')->first()->id;
                                    Assignment::create([
                                        'asset_id' => $record->asset_id,
                                        'employee_id' => $transfer->to_employee,
                                        'assignment_status' => $pendingApprovalStatusId,
                                        'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
                                        'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
                                    ]);

                                    // Update the transfer record
                                    $transfer->update([
                                        'status' => $pendingApprovalStatusId,
                                    ]);

                                    Notification::make()
                                        ->title('Transfer Approved')
                                        ->body('The asset is now for approval by the receiving employee.')
                                        ->success()
                                        ->send();
                                    return redirect()->to(AssignmentResource::getUrl('index'));
                                }),
                            Tables\Actions\Action::make('decline')
                                ->label('Decline')
                                ->color('danger')
                                ->form([
                                    Forms\Components\Textarea::make('reason')
                                        ->label('Reason for decline')
                                        ->required()
                                        ->maxLength(255),
                                ])
                                ->requiresConfirmation()
                                ->modalHeading('Decline Transfer')
                                ->modalDescription('Please provide a reason for declining this transfer.')
                                ->modalSubmitActionLabel('Decline')
                                ->action(function (Assignment $record, array $data) {
                                    // Modify the reason for decline
                                    $getReason = $data['reason'];
                                    $reason = "Transfer Declined by Admin: {$getReason}";

                                    $activeStatusId = AssignmentStatus::where('assignment_status', 'Active')->first()->id;
                                    $record->update([
                                        'employee_id' => $record->employee_id,
                                        'assignment_status' => $activeStatusId,
                                        'remarks' => $reason,
                                    ]);

                                    // Update the transfer record
                                    $declinedStatusId = AssignmentStatus::where('assignment_status', 'Declined')->first()->id;
                                    $transfer = Transfer::where('assignment_id', $record->id)->firstOrFail();
                                    $transfer->update([
                                        'assignment_id' => $record->id,
                                        'to_employee' => $transfer->to_employee,
                                        'status' => $declinedStatusId,
                                    ]);

                                    Notification::make()
                                        ->title('Transfer Declined')
                                        ->success()
                                        ->send();
                                    return redirect()->to(AssignmentResource::getUrl('index'));
                                }),
                        ])
                        ->modalFooterActionsAlignment(Alignment::Center)
                        ->modalWidth('max-w-sm'),
                    Action::make('Option to Buy')
                        ->form([
                            Hidden::make('id')
                                ->default(fn($record) => $record->id)
                                ->required(),
                            Hidden::make('asset_id')
                                ->default(fn($record) => $record->asset_id)
                                ->required(),
                            TextInput::make('asset_display')
                                ->label('Assets')
                                ->default(fn($record) => "{$record->asset->id} - {$record->asset->brand} {$record->asset->model}")
                                ->disabled()
                                ->dehydrated(false),
                            Hidden::make('from_employee_id')
                                ->default(fn($record) => $record->employee->id_num)
                                ->required(),
                            TextInput::make('from_employee_display')
                                ->label('Sell to Employee')
                                ->default(fn($record) => "{$record->employee->id_num} - {$record->employee->first_name} {$record->employee->last_name}")
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
                                ->default(fn($record) => Carbon::parse($record->start_date)->format('Y-m-d')),
                            Hidden::make('old_end_date')
                                ->default(fn($record) => Carbon::parse($record->end_date)->format('Y-m-d')),
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
                        ->visible(fn(Assignment $record): bool => $record->assignment_status == AssignmentStatus::where('assignment_status', 'Active')->first()->id)
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
