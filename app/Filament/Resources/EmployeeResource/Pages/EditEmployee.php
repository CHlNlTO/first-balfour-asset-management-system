<?php
// File: app/Filament/Resources/EmployeeResource/Pages/EditEmployee.php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\CEMREmpService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Employee')
                ->icon('heroicon-o-eye'),
            Actions\DeleteAction::make()
                ->label('Delete Employee')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Employee updated')
            ->body('The employee information has been updated successfully.');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing employee service data if it exists
        $empService = CEMREmpService::where('user_id', $this->record->id)->first();

        if ($empService) {
            $data['create_emp_service'] = true;
            $data['emp_service'] = [
                'company_id' => $empService->company_id,
                'rank_id' => $empService->rank_id,
                'emp_stat_id' => $empService->emp_stat_id,
                'curr_pos_id' => $empService->curr_pos_id,
                'division_id' => $empService->division_id,
                'project_id' => $empService->project_id,
                'cost_code_id' => $empService->cost_code_id,
                'project_hired_date' => $empService->project_hired_date,
                'comments' => $empService->comments,
            ];
        } else {
            $data['create_emp_service'] = false;
            $data['emp_service'] = [];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure boolean fields are properly handled
        $data['active'] = (bool) ($data['active'] ?? false);
        $data['cbe'] = (bool) ($data['cbe'] ?? false);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update the employee record
        $record->update($data);

        // Handle employee service
        $existingService = CEMREmpService::where('user_id', $record->id)->first();

        if ($data['create_emp_service'] ?? false) {
            $empServiceData = $data['emp_service'] ?? [];

            if (!empty($empServiceData) && !empty($empServiceData['company_id'])) {
                // Prepare the emp_service data
                $serviceData = [
                    'user_id' => $record->id,
                    'id_num' => $record->id_num,
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

                if ($existingService) {
                    // Update existing service
                    $existingService->update($serviceData);

                    Notification::make()
                        ->success()
                        ->title('Employee service updated')
                        ->body('Employee service assignment has been updated successfully.')
                        ->send();
                } else {
                    // Create new service
                    CEMREmpService::create($serviceData);

                    Notification::make()
                        ->success()
                        ->title('Employee service created')
                        ->body('Employee service assignment has been created successfully.')
                        ->send();
                }
            }
        } else {
            // If toggle is off, delete existing service if it exists
            if ($existingService) {
                $existingService->delete();

                Notification::make()
                    ->success()
                    ->title('Employee service removed')
                    ->body('Employee service assignment has been removed.')
                    ->send();
            }
        }

        return $record;
    }
}
