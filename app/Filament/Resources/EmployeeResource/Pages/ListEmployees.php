<?php
// File: app/Filament/Resources/EmployeeResource/Pages/ListEmployees.php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Employee')
                ->icon('heroicon-o-plus'),
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
