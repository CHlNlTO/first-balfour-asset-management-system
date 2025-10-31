<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
