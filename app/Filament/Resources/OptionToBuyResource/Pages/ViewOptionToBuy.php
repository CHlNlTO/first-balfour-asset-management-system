<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;

class ViewOptionToBuy extends ViewRecord
{
    protected static string $resource = OptionToBuyResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Option to Buy Details')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Option to Buy ID')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('assignment.id')
                            ->label('Assignment ID')
                            ->url(fn ($record) => route('filament.admin.resources.assignments.view', ['record' => $record->assignment_id]))
                            ->weight(FontWeight::Bold),
                        TextEntry::make('employee')
                            ->label('Employee')
                            ->getStateUsing(fn ($record) => $record->assignment->employee->first_name . ' ' . $record->assignment->employee->last_name)
                            ->url(fn ($record) => route('filament.admin.resources.employees.view', ['record' => $record->assignment->employee->id_num]))
                            ->weight(FontWeight::Bold),
                        TextEntry::make('asset')
                            ->label('Asset')
                            ->getStateUsing(fn ($record) => $record->assignment->asset->brand . ' ' . $record->assignment->asset->model)
                            ->url(fn ($record) => route('filament.admin.resources.assets.view', ['record' => $record->assignment->asset_id]))
                            ->weight(FontWeight::Bold),
                        TextEntry::make('asset_cost')
                            ->label('Asset Cost')
                            ->money('php')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('status.assignment_status')
                            ->label('Status')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime()
                            ->weight(FontWeight::Bold),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime()
                            ->weight(FontWeight::Bold),
                    ])
                    ->columns(2),
            ]);
    }
}
