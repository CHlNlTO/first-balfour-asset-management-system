<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_report')
                ->label('Export Report')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(route('export.asset-report'))
                ->openUrlInNewTab()
                ->extraAttributes([
                    'class' => 'bg-green-600 hover:bg-green-700'
                ])
        ];
    }
}
