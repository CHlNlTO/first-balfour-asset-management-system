<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\CEMREmployee;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;

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
                            ->placeholder('N/A')
                            ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('id_num')
                            ->label('ID Number')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('email')
                            ->label('Email')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('empService.position.name')
                            ->label('Position')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('empService.rank.name')
                            ->label('Rank')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('empService.project.name')
                            ->label('Project')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('empService.division.name')
                            ->label('Division')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                        TextEntry::make('empService.status.name')
                            ->label('Employee Status')
                            ->placeholder('N/A')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1000),
                    ])
                    ->columns(2),
            ]);
    }

}
