<?php
// File: app/Filament/Resources/EmployeeResource/Pages/CreateEmployee.php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\CEMREmpService;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee created')
            ->body('The employee has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set default values if not provided
        $data['active'] = $data['active'] ?? true;
        $data['cbe'] = $data['cbe'] ?? false;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Create the employee record first
        $employee = static::getModel()::create($data);

        // Create employee service record if requested
        if ($data['create_emp_service'] ?? false) {
            $empServiceData = $data['emp_service'] ?? [];

            if (!empty($empServiceData) && !empty($empServiceData['company_id'])) {
                // Prepare the emp_service data
                $serviceData = [
                    'user_id' => $employee->id,
                    'id_num' => $employee->id_num,
                    'company_id' => $empServiceData['company_id'],
                    'rank_id' => $empServiceData['rank_id'] ?? null,
                    'emp_stat_id' => $empServiceData['emp_stat_id'] ?? null,
                    'curr_pos_id' => $empServiceData['curr_pos_id'] ?? null,
                    'division_id' => $empServiceData['division_id'] ?? null,
                    'project_id' => $empServiceData['project_id'] ?? null,
                    'cost_code_id' => $empServiceData['cost_code_id'] ?? null,
                    'project_hired_date' => $empServiceData['project_hired_date'] ?? null,
                    'comments' => $empServiceData['comments'] ?? null,
                ];

                // Remove null values
                $serviceData = array_filter($serviceData, fn($value) => $value !== null);

                // Create the employee service record
                CEMREmpService::create($serviceData);

                // Send additional notification
                Notification::make()
                    ->success()
                    ->title('Employee service created')
                    ->body('Employee service assignment has been created successfully.')
                    ->send();
            }
        }

        return $employee;
    }
}
