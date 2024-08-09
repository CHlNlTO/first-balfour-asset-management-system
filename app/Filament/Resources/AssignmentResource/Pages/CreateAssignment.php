<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Models\Assignment;
use App\Filament\Resources\AssignmentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    protected function handleMultipleAssignmentsCreation(array $data)
    {
        $createdAssignments = [];

        DB::transaction(function () use ($data, &$createdAssignments) {
            foreach ($data['asset_id'] as $assetId) {
                $assignmentData = $data;
                $assignmentData['asset_id'] = $assetId;
                $createdAssignments[] = $this->createSingleAssignment($assignmentData);
            }
        });

        return end($createdAssignments); // Return the last created assignment
    }

    protected function handleSingleAssignmentCreation(array $data): Assignment
    {
        return DB::transaction(function () use ($data) {
            return $this->createSingleAssignment($data);
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
}
