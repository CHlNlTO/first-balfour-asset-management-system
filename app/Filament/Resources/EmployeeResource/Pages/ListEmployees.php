<?php
// File: app/Filament/Resources/EmployeeResource/Pages/ListEmployees.php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Imports\CEMREmployeesImport;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Employee')
                ->icon('heroicon-o-plus'),

            Actions\Action::make('importEmployees')
                ->label('Import Employees')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('primary')
                ->modalHeading('Import Employees from Excel/CSV')
                ->modalSubmitActionLabel('Start Import')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('Upload file (.xlsx, .xls, .csv)')
                        ->required()
                        ->disk('local')
                        ->directory('imports/employees')
                        ->preserveFilenames()
                        ->acceptedFileTypes([
                            'text/csv',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ]),
                ])
                ->action(function (array $data) {
                    try {
                        // Queue the import for background processing; falls back to sync if queue driver is sync
                        $userId = Auth::id();
                        Log::info('[Employees Import] Queuing import', [
                            'user_id' => $userId,
                            'file' => $data['file'] ?? null,
                            'disk' => 'local',
                            'queue_driver' => config('queue.default'),
                        ]);
                        Excel::queueImport(new CEMREmployeesImport($userId, $data['file']), $data['file'], 'local');

                        Notification::make()
                            ->title('Employee import started')
                            ->body('Your file has been accepted and will be processed shortly. Queue driver: ' . config('queue.default'))
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Log::error('[Employees Import] Failed to start import', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                        Notification::make()
                            ->title('Employee import failed to start')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Employees')
                ->icon('heroicon-o-users'),

            'active' => Tab::make('Active')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true))
                ->badge(fn () => $this->getModel()::where('active', true)->count()),

            'inactive' => Tab::make('Inactive')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false))
                ->badge(fn () => $this->getModel()::where('active', false)->count()),

            'no_email' => Tab::make('No Email')
                ->icon('heroicon-o-envelope-open')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('email')->orWhere('email', ''))
                ->badge(fn () => $this->getModel()::whereNull('email')->orWhere('email', '')->count()),

            'cbe_qualified' => Tab::make('CBE Qualified')
                ->icon('heroicon-o-academic-cap')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('cbe', true))
                ->badge(fn () => $this->getModel()::where('cbe', true)->count()),

            'recent' => Tab::make('Recent Hires')
                ->icon('heroicon-o-calendar-days')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('original_hired_date', '>=', now()->subDays(30)))
                ->badge(fn () => $this->getModel()::where('original_hired_date', '>=', now()->subDays(30))->count()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Add any widgets here if needed
        ];
    }
}
