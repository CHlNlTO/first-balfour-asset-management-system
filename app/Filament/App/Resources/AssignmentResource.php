<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('asset_id')
                ->label('Asset ID')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('asset_name')
                ->label('Asset')
                ->sortable()
                ->searchable()
                ->getStateUsing(function (Assignment $record): string {
                    $asset = $record->asset;
                    return $asset ? " {$asset->brand} {$asset->model}" : 'N/A';
                }),
            Tables\Columns\TextColumn::make('assignment_status')
                ->label('Assignment Status')
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
                ->searchable(),
            Tables\Columns\TextColumn::make('end_date')
                ->label('End Date')
                ->date()
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
                //
            ])
        ->actions([
            Tables\Actions\Action::make('manage')
                ->label('Manage')
                ->icon('heroicon-o-cog')
                ->color('primary')
                ->visible(fn (Assignment $record): bool => $record->assignment_status == AssignmentStatus::where('assignment_status', 'Pending Approval')->first()->id)
                ->modalIcon('heroicon-o-cog')
                ->modalHeading('Manage Assignment')
                ->modalDescription(fn (Assignment $record) => "{$record->asset->brand} {$record->asset->model}")
                ->modalAlignment(Alignment::Center)
                ->modalFooterActions([
                    Tables\Actions\Action::make('approve')
                        ->label('Approve')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Assignment')
                        ->modalDescription('Are you sure you want to approve this assignment?')
                        ->modalSubmitActionLabel('Yes, approve')
                        ->action(function (Assignment $record) {
                            $activeStatusId = AssignmentStatus::where('assignment_status', 'Active')->first()->id;
                            $record->update(['assignment_status' => $activeStatusId]);
                            Notification::make()
                                ->title('Assignment Approved')
                                ->success()
                                ->send();
                            return redirect()->to(AssignmentResource::getUrl('index'));
                        }),
                    Tables\Actions\Action::make('decline')
                        ->label('Decline')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->form([
                            Forms\Components\Textarea::make('reason')
                                ->label('Reason for decline')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->requiresConfirmation()
                        ->modalHeading('Decline Assignment')
                        ->modalDescription('Please provide a reason for declining this assignment.')
                        ->modalSubmitActionLabel('Decline')
                        ->action(function (Assignment $record, array $data) {
                            $declinedStatusId = AssignmentStatus::where('assignment_status', 'Declined')->first()->id;
                            $record->update([
                                'assignment_status' => $declinedStatusId,
                                'remarks' => $data['reason'],
                            ]);
                            Notification::make()
                                ->title('Assignment Declined')
                                ->success()
                                ->send();
                            return redirect()->to(AssignmentResource::getUrl('index'));
                        }),
                    ])
                ->modalFooterActionsAlignment(Alignment::Center)
                ->modalWidth('max-w-sm'),
            Tables\Actions\Action::make('transfer')
                ->label('Transfer')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->visible(fn (Assignment $record): bool => $record->assignment_status == AssignmentStatus::where('assignment_status', 'Active')->first()->id)
                ->form([
                    Hidden::make('from_employee_id')
                        ->default(Auth::user()->id_num),
                    Forms\Components\Select::make('to_employee_id')
                        ->label('Transfer To')
                        ->placeholder('Select from registered employees')
                        ->relationship('employee', 'id')
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->id_num} - {$record->first_name} {$record->last_name}")
                        ->searchable()
                        ->required(),
                ])
                ->action(function (Assignment $record, array $data) {
                    // Update current assignment status to "In Transfer"
                    $inTransferStatusId = AssignmentStatus::where('assignment_status', 'In Transfer')->first()->id;
                    $record->update([
                        'employee_id' => $data['from_employee_id'],
                        'assignment_status' => $inTransferStatusId
                    ]);

                    // Create a new pending assignment for the receiving employee
                    Assignment::create([
                        'asset_id' => $record->asset_id,
                        'employee_id' => $data['to_employee_id'],
                        'assignment_status' => $inTransferStatusId,
                        'start_date' => now(),
                    ]);

                    Notification::make()
                        ->title('Transfer Initiated')
                        ->body('The transfer request has been sent to the admin for approval.')
                        ->success()
                        ->send();

                    return redirect()->to(AssignmentResource::getUrl('index'));
                })
                ->requiresConfirmation()
                ->modalHeading('Transfer Assignment')
                ->modalDescription('Are you sure you want to transfer this assignment?')
                ->modalSubmitActionLabel('Yes, transfer'),
            Tables\Actions\ViewAction::make(),
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

        $inTransferStatusId = AssignmentStatus::where('assignment_status', 'In Transfer')->first()->id;

        return parent::getEloquentQuery()
            ->where('employee_id', Auth::user()->id_num)
            ->where('assignment_status', '!=', $inTransferStatusId);
    }
}
