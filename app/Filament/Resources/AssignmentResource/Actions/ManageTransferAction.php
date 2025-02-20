<?php

namespace App\Filament\Resources\AssignmentResource\Actions;

use App\Filament\App\Resources\AssignmentResource;
use App\Filament\App\Resources\AssignmentResource\Actions\ManageApprovalAction;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\Transfer;
use App\Models\CEMREmployee;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ManageTransferAction
{
    public static function make(): Action
    {
        return Action::make('manageTransfer')
            ->label('Manage Transfer')
            ->icon('heroicon-o-cog')
            ->color('primary')
            ->visible(
                fn(Assignment $record): bool =>
                $record->assignment_status === AssignmentStatus::where('assignment_status', 'In Transfer')->first()->id
            )
            ->modalIcon('heroicon-o-cog')
            ->modalHeading('Manage Transfer')
            ->modalDescription(function (Assignment $record): string {
                $transfer = static::getLatestTransfer($record);
                $toEmployee = static::getToEmployee($transfer);

                return "Transfer {$record->asset->model->brand->name} {$record->asset->model->name} to {$toEmployee->first_name} {$toEmployee->last_name}?";
            })
            ->modalAlignment(Alignment::Center)
            ->modalFooterActions([
                static::makeApproveAction(),
                static::makeDeclineAction(),
            ])
            ->modalFooterActionsAlignment(Alignment::Center)
            ->modalWidth('max-w-sm');
    }

    protected static function getLatestTransfer(Assignment $record): Model
    {
        $transfer = Transfer::where('assignment_id', $record->id)
            ->orderBy('id', 'desc')
            ->firstOrFail();

        Log::info("Transfer record:", $transfer->toArray());
        return $transfer;
    }

    protected static function getToEmployee(Transfer $transfer): Model
    {
        return CEMREmployee::where('id_num', $transfer->to_employee)->firstOrFail();
    }


    protected static function makeApproveAction(): Action
    {
        return Action::make('approve')
            ->label('Approve')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Approve Transfer')
            ->modalDescription('Are you sure you want to approve this transfer?')
            ->form([
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->after('start_date'),
            ])
            ->modalSubmitActionLabel('Yes, approve')
            ->action(function (Assignment $record, array $data): void {
                static::handleApproval($record, $data);
            });
    }

    protected static function makeDeclineAction(): Action
    {
        return Action::make('decline')
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
            ->action(function (Assignment $record, array $data): void {
                static::handleDecline($record, $data);
            });
    }

    protected static function handleApproval(Assignment $record, array $data)
    {
        $transfer = Transfer::where('assignment_id', $record->id)->firstOrFail();
        $pendingApprovalStatusId = AssignmentStatus::where('assignment_status', 'Pending Approval')->first()->id;
        $transferredStatusId = AssignmentStatus::where('assignment_status', 'Transferred')->first()->id;

        // Update original assignment to Transferred status
        $record->update([
            'assignment_status' => $transferredStatusId,
            'end_date' => now(),
        ]);

        // Create new assignment for receiving employee
        Assignment::create([
            'asset_id' => $record->asset_id,
            'employee_id' => $transfer->to_employee,
            'assignment_status' => $pendingApprovalStatusId,
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => isset($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : null,
            'remarks' => "Transfer from {$record->employee->first_name} {$record->employee->last_name}",
        ]);

        // Update transfer record
        $transfer->update([
            'status' => $transferredStatusId,  // Change this to Transferred instead of Pending Approval
        ]);

        static::sendApprovalNotification($record, $transfer);
        return redirect()->to(AssignmentResource::getUrl('index'));
    }

    protected static function handleDecline(Assignment $record, array $data): void
    {
        $reason = "Transfer Declined by Admin: {$data['reason']}";

        $activeStatusId = AssignmentStatus::where('assignment_status', 'Active')->first()->id;
        $record->update([
            'employee_id' => $record->employee_id,
            'assignment_status' => $activeStatusId,
            'remarks' => $reason,
        ]);

        $declinedStatusId = AssignmentStatus::where('assignment_status', 'Declined')->first()->id;
        $transfer = Transfer::where('assignment_id', $record->id)->firstOrFail();
        $transfer->update([
            'assignment_id' => $record->id,
            'to_employee' => $transfer->to_employee,
            'status' => $declinedStatusId,
        ]);

        static::sendDeclineNotification();
    }

    protected static function sendApprovalNotification($record, $transfer): void
    {
        Notification::make()
            ->title('Transfer Approved')
            ->body('The asset is now for approval by the receiving employee.')
            ->success()
            ->send();

        Notification::make()
            ->title('Asset for Approval')
            ->icon('heroicon-o-information-circle')
            ->body(Str::markdown("The asset **{$record->asset->brand} {$record->asset->model}** is now available for your approval."))
            ->info()
            ->sendToDatabase(User::where('id_num', $transfer->to_employee)->firstOrFail());
    }

    protected static function sendDeclineNotification(): void
    {
        Notification::make()
            ->title('Transfer Declined')
            ->success()
            ->send();
    }
}
