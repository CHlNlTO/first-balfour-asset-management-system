<?php

namespace App\Filament\App\Resources\AssignmentResource\Actions;

use App\Filament\App\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use App\Models\Transfer;
use Carbon\Carbon;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeTransferAction
{
    public static function make(): Action
    {
        return Action::make('transfer')
            ->label('Transfer')
            ->icon('heroicon-o-arrows-right-left')
            ->color('primary')
            ->visible(
                fn(Assignment $record): bool =>
                $record->assignment_status === AssignmentStatus::where('assignment_status', 'Active')->first()->id
            )
            ->form(
                static::getTransferFormSchema()
            )
            ->action(function (Assignment $record, array $data): void {
                static::handleTransfer($record, $data);
            })
            ->after(function () {
                return redirect()->to(AssignmentResource::getUrl('index'));
            })
            ->requiresConfirmation()
            ->modalHeading('Transfer Assignment')
            ->modalDescription('Are you sure you want to transfer this assignment?')
            ->modalSubmitActionLabel('Yes, transfer');
    }

    protected static function getTransferFormSchema(): array
    {
        return [
            Hidden::make('from_employee_id')
                ->default(fn(): string => Auth::user()->id_num)
                ->required(),

            Select::make('to_employee_id')
                ->label('Transfer To')
                ->placeholder('Select from registered employees')
                ->relationship('employee', 'id_num')
                ->getOptionLabelFromRecordUsing(
                    fn(Model $record): string =>
                    "{$record->id_num} - {$record->first_name} {$record->last_name}"
                )
                ->searchable(['id_num', 'first_name', 'last_name'])
                ->required()
                // ->different('from_employee_id')
                ->helperText('Select the employee to transfer this assignment to'),
        ];
    }

    protected static function handleTransfer(Assignment $record, array $data): void
    {
        DB::beginTransaction();

        try {
            Log::info('Starting employee transfer process', [
                'assignment_id' => $record->id,
                'from_employee' => $data['from_employee_id'],
                'to_employee' => $data['to_employee_id']
            ]);

            static::validateTransferData($data);
            static::updateAssignmentStatus($record, $data);
            static::createTransferRecord($record, $data);
            static::sendNotifications();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            static::handleError($e);
            throw $e;
        }
    }

    protected static function validateTransferData(array $data): void
    {
        // if (empty($data['to_employee_id'])) {
        //     throw new \InvalidArgumentException('Recipient employee must be specified');
        // }

        // if ($data['from_employee_id'] === $data['to_employee_id']) {
        //     throw new \InvalidArgumentException('Cannot transfer to the same employee');
        // }
    }

    protected static function updateAssignmentStatus(Assignment $record, array $data): void
    {
        $inTransferStatusId = AssignmentStatus::where('assignment_status', 'In Transfer')->first()->id;
        $toEmployee = CEMREmployee::where('id_num', $data['to_employee_id'])->first();

        $record->update([
            'employee_id' => $data['from_employee_id'],
            'assignment_status' => $inTransferStatusId,
            'remarks' => 'In transfer to ' . $toEmployee->first_name . ' ' . $toEmployee->last_name,
            'updated_at' => Carbon::now(),
        ]);

        Log::info('Updated assignment status', [
            'assignment_id' => $record->id,
            'new_status' => 'In Transfer'
        ]);
    }

    protected static function createTransferRecord(Assignment $record, array $data): void
    {
        $inTransferStatusId = AssignmentStatus::where('assignment_status', 'In Transfer')->first()->id;

        $transfer = Transfer::create([
            'assignment_id' => $record->id,
            'from_employee' => $data['from_employee_id'],
            'to_employee' => $data['to_employee_id'],
            'status' => $inTransferStatusId,
            'transfer_date' => Carbon::now(),
        ]);

        Log::info('Created transfer record', [
            'transfer_id' => $transfer->id,
            'assignment_id' => $record->id
        ]);
    }

    protected static function sendNotifications(): void
    {
        $recipient = Auth::user();

        // Create and send the success notification
        $notification = Notification::make()
            ->title('Transfer Initiated')
            ->body('The transfer request has been sent to the admin for approval.')
            ->success();

        // Send to UI
        $notification->send();

        // Send to database if we have a recipient
        if ($recipient) {
            $notification->sendToDatabase($recipient);
        }

        Log::info('Sent transfer notifications', [
            'recipient_id' => $recipient?->id_num ?? 'unknown'
        ]);
    }

    protected static function handleError(\Exception $e): void
    {
        Log::error('Error in employee transfer process', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        Notification::make()
            ->title('Transfer Failed')
            ->body('An error occurred while processing the transfer. Please try again or contact support.')
            ->danger()
            ->persistent()
            ->send();
    }
}
