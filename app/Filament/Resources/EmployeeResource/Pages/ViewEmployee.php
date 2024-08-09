<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\CEMREmployee;
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
            //
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
                Section::make('Employee Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name')
                            ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name),
                        TextEntry::make('id_num')
                            ->label('ID Number'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('empService.position.name')
                            ->label('Position'),
                        TextEntry::make('empService.rank.name')
                            ->label('Rank'),
                        TextEntry::make('empService.project.name')
                            ->label('Project'),
                        TextEntry::make('empService.division.name')
                            ->label('Division'),
                        TextEntry::make('empService.status.name')
                            ->label('Employee Status'),
                    ])
                    ->columns(2),
            ]);
    }

}
