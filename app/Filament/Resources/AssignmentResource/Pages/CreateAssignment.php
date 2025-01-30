<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\App\Resources\AssignmentResource\Actions\ManageApprovalAction;
use App\Models\Assignment;
use App\Filament\Resources\AssignmentResource;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreateAssignment extends CreateRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        Log::info("Data received in handleRecordCreation:", $data);

        if (isset($data['asset_id']) && is_array($data['asset_id'])) {
            return $this->handleMultipleAssignmentsCreation($data);
        }

        return $this->handleSingleAssignmentCreation($data);
    }

    protected function handleMultipleAssignmentsCreation(array $data): Assignment
    {
        $createdAssignments = [];

        DB::transaction(function () use ($data, &$createdAssignments) {
            foreach ($data['asset_id'] as $assetId) {
                $assignmentData = $data;
                $assignmentData['asset_id'] = $assetId;
                $assignment = $this->createSingleAssignment($assignmentData);
                $createdAssignments[] = $assignment;

                // Send notification for each asset
                $this->notifyReceivingEmployee($assignment);
            }
        });

        return end($createdAssignments);
    }

    protected function handleSingleAssignmentCreation(array $data): Assignment
    {
        return DB::transaction(function () use ($data): Assignment {
            $assignment = $this->createSingleAssignment($data);
            $this->notifyReceivingEmployee($assignment);
            return $assignment;
        });
    }

    protected function createSingleAssignment(array $data): Assignment
    {
        return Assignment::create([
            'asset_id' => $data['asset_id'],
            'employee_id' => $data['employee_id'],
            'assignment_status' => $data['assignment_status'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function notifyReceivingEmployee(Assignment $assignment): void
    {
        try {
            // Find the receiving employee using the employee_id (id_num)
            $employee = CEMREmployee::where('id_num', $assignment->employee_id)->first();

            if (!$employee) {
                Log::warning('Could not find employee for notification', [
                    'employee_id' => $assignment->employee_id,
                    'assignment_id' => $assignment->id
                ]);
                return;
            }

            // Create and send notification
            Notification::make()
                ->title('New Asset Assignment')
                ->icon('heroicon-o-clipboard-document-check')
                ->info()
                ->body(Str::markdown("Asset **{$assignment->asset->asset}** has been assigned to you."))
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.app.resources.assignments.view', ['record' => $assignment]))
                        ->label('View Assignment'),

                ])
                ->sendToDatabase(User::where('id_num', $assignment->employee_id)->firstOrFail());
            Log::info('Sent assignment notification', [
                'assignment_id' => $assignment->id,
                'employee_id' => $employee->id_num
            ]);
        } catch (\Exception $e) {
            Log::error("Error sending assignment notification: " . $e->getMessage(), [
                'assignment_id' => $assignment->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
