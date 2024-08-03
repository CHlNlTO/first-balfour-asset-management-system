<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
                Section::make('Employee Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('position')
                            ->label('Position'),
                        TextEntry::make('rank')
                            ->label('Rank'),
                        TextEntry::make('project')
                            ->label('Project'),
                        TextEntry::make('department')
                            ->label('Department'),
                        TextEntry::make('employee_status')
                            ->label('Employee Status'),
                    ])
                    ->columns(2),
            ]);
    }

}
