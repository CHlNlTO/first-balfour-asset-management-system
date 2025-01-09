<?php

namespace App\Filament\App\Resources\AssignmentResource\Actions;

use App\Filament\App\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\AssetStatus;
use App\Models\Transfer;
use Carbon\Carbon;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TableApprovalAction
{
    public static function make(): Action
    {
        return Action::make('manage')
            ->label('Approve')
            ->icon('heroicon-o-check-badge')
            ->requiresConfirmation()
            ->color('primary')
            ->visible(
                fn(Assignment $record): bool =>
                $record->assignment_status === AssignmentStatus::where('assignment_status', 'Pending Approval')->first()->id
            )
            ->modalIcon('heroicon-o-cog')
            ->modalHeading(
                fn(Assignment $record): string =>
                "{$record->asset->id} - {$record->asset->brand} {$record->asset->model}"
            )
            ->modalDescription("Approve if you've received the asset. Decline and state a reason if you haven't.")
            ->modalAlignment(Alignment::Center)
            ->modalFooterActions([
                static::makeApproveAction(),
                static::makeDeclineAction(),
            ])
            ->modalFooterActionsAlignment(Alignment::Center)
            ->modalWidth('max-w-sm')
            ->after(function () {
                return redirect()->to(AssignmentResource::getUrl('index'));
            });
    }

    protected static function makeApproveAction(): Action
    {
        return Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check-badge')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Approve Assignment')
            ->modalDescription('Are you sure you want to approve this assignment?')
            ->modalSubmitActionLabel('Yes, approve')
            ->action(function (Assignment $record): void {
                static::handleApproval($record);
            });
    }

    protected static function makeDeclineAction(): Action
    {
        return Action::make('decline')
            ->label('Decline')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->form([
                Textarea::make('reason')
                    ->label('Reason for decline')
                    ->required()
                    ->maxLength(255),
            ])
            ->requiresConfirmation()
            ->modalHeading('Decline Assignment')
            ->modalDescription('Please provide a reason for declining this assignment.')
            ->modalSubmitActionLabel('Decline')
            ->action(function (Assignment $record, array $data): void {
                static::handleDecline($record, $data);
            });
    }

    protected static function handleApproval(Assignment $record)
    {
        DB::beginTransaction();

        try {
            Log::info('Starting assignment approval process', [
                'assignment_id' => $record->id,
                'asset_id' => $record->asset_id
            ]);

            $statuses = static::getRequiredStatuses();

            static::updateCurrentAssignment($record, $statuses['active']);
            static::updateAssetStatus($record);
            static::handleTransferIfExists($record, $statuses);

            DB::commit();

            static::sendApprovalNotification($record);

            return redirect()->to(AssignmentResource::getUrl('index'));
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
            throw $e;
        }
    }

    protected static function handleDecline(Assignment $record, array $data)
    {
        DB::beginTransaction();

        try {
            Log::info('Starting assignment decline process', [
                'assignment_id' => $record->id,
                'reason' => $data['reason']
            ]);

            $statuses = static::getRequiredStatuses();

            static::updateDeclinedAssignment($record, $data, $statuses['declined']);
            static::handleDeclinedTransfer($record, $data, $statuses);

            DB::commit();

            static::sendDeclineNotification($record);

            return redirect()->to(AssignmentResource::getUrl('index'));
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
            throw $e;
        }
    }

    protected static function getRequiredStatuses(): array
    {
        return [
            'active' => AssignmentStatus::where('assignment_status', 'Active')->first()->id,
            'transferred' => AssignmentStatus::where('assignment_status', 'Transferred')->first()->id,
            'declined' => AssignmentStatus::where('assignment_status', 'Declined')->first()->id,
            'inactive' => AssignmentStatus::where('assignment_status', 'Inactive')->first()->id,
        ];
    }

    protected static function updateCurrentAssignment(Assignment $record, int $statusId): void
    {
        $record->update([
            'assignment_status' => $statusId,
            'remarks' => 'Asset received.',
            'updated_at' => Carbon::now(),
        ]);

        Log::info('Updated current assignment', [
            'assignment_id' => $record->id,
            'new_status' => 'Active'
        ]);
    }

    protected static function updateAssetStatus(Assignment $record): void
    {
        $activeAssetStatusId = AssetStatus::where('asset_status', 'Active')->first()->id;

        $record->asset->update([
            'asset_status' => $activeAssetStatusId,
            'updated_at' => Carbon::now(),
        ]);

        Log::info('Updated asset status', [
            'asset_id' => $record->asset_id,
            'new_status' => 'Active'
        ]);
    }

    protected static function handleTransferIfExists(Assignment $record, array $statuses): void
    {
        $transfer = static::findRelatedTransfer($record);

        if ($transfer) {
            // Update old assignment
            $transfer->assignment->update([
                'assignment_status' => $statuses['transferred'],
                'updated_at' => Carbon::now(),
            ]);

            // Update transfer record
            $transfer->update([
                'status' => $statuses['transferred'],
                'updated_at' => Carbon::now(),
            ]);

            Log::info('Updated transfer records', [
                'transfer_id' => $transfer->id,
                'old_assignment_id' => $transfer->assignment_id
            ]);
        }
    }

    protected static function updateDeclinedAssignment(Assignment $record, array $data, int $statusId): void
    {
        $record->update([
            'assignment_status' => $statusId,
            'remarks' => $data['reason'],
            'start_date' => Carbon::parse($record->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($record->end_date)->format('Y-m-d'),
            'updated_at' => Carbon::now(),
        ]);

        Log::info('Updated declined assignment', [
            'assignment_id' => $record->id,
            'reason' => $data['reason']
        ]);
    }
    protected static function handleDeclinedTransfer(Assignment $record, array $data, array $statuses): void
    {
        $transfer = static::findRelatedTransfer($record);

        if ($transfer) {
            // Update old assignment
            $transfer->assignment->update([
                'assignment_status' => $statuses['inactive'],
                'remarks' => 'Assignment declined by the new assignee.',
                'updated_at' => Carbon::now(),
            ]);

            // Update transfer status
            $transfer->update([
                'status' => $statuses['declined'],
                'updated_at' => Carbon::now(),
            ]);

            Log::info('Updated declined transfer records', [
                'transfer_id' => $transfer->id,
                'old_assignment_id' => $transfer->assignment_id
            ]);
        }
    }

    protected static function findRelatedTransfer(Assignment $record): ?Model
    {
        return Transfer::where('to_employee', $record->employee_id)
            ->whereHas('assignment', function ($query) use ($record) {
                $query->where('asset_id', $record->asset_id);
            })
            ->orderBy('id', 'desc')
            ->first();
    }

    protected static function sendApprovalNotification(Assignment $record): void
    {
        $transfer = static::findRelatedTransfer($record);

        $title = $transfer
            ? 'Assignment Approved and Transfer Completed'
            : 'Assignment Approved';

        $recipient = Auth::user();

        // Create and send the success notification
        $notification = Notification::make()
            ->title($title)
            ->body('Asset has been successfully assigned.')
            ->success();

        // Send to UI
        $notification->send();

        // Send to database if we have a recipient
        if ($recipient) {
            $notification->sendToDatabase($recipient);
        }
    }

    protected static function sendDeclineNotification(Assignment $record): void
    {
        $transfer = static::findRelatedTransfer($record);

        $title = $transfer
            ? 'Assignment Declined and Transfer Cancelled'
            : 'Assignment Declined';

        $recipient = auth()->user();

        Notification::make()
            ->title($title)
            ->success()
            ->send()
            ->sendToDatabase($recipient);
    }

    protected static function handleError(\Exception $e): void
    {
        Log::error('Error in assignment approval/decline process', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        Notification::make()
            ->title('Error Processing Assignment')
            ->body('An error occurred while processing the assignment. Please try again or contact support.')
            ->danger()
            ->persistent()
            ->send();
    }
}
