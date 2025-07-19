<?php
// File: app/Filament/Resources/EmployeeResource/Pages/ViewEmployee.php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\CEMREmployee;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Grid;
use Filament\Support\Enums\FontWeight;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Employee')
                ->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()
                ->label('Delete Employee')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Employee Profile')
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('Full Name')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->copyable()
                            ->copyMessage('Name copied!')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Personal Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('id_num')
                                    ->label('Employee ID')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Employee ID copied!')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->copyable()
                                    ->copyMessage('Email copied!')
                                    ->icon('heroicon-m-envelope')
                                    ->placeholder('No email provided'),

                                TextEntry::make('sex')
                                    ->label('Gender')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Male' => 'blue',
                                        'Female' => 'pink',
                                        default => 'gray',
                                    })
                                    ->placeholder('Not specified'),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextEntry::make('birthdate')
                                    ->label('Date of Birth')
                                    ->date('F j, Y')
                                    ->placeholder('Not provided'),

                                TextEntry::make('city')
                                    ->label('City')
                                    ->placeholder('Not provided'),

                                TextEntry::make('original_hired_date')
                                    ->label('Hire Date')
                                    ->date('F j, Y')
                                    ->placeholder('Not provided'),
                            ]),
                    ])
                    ->columns(3),

                Section::make('Employment Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                IconEntry::make('active')
                                    ->label('Employment Status')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),

                                IconEntry::make('cbe')
                                    ->label('CBE Status')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-academic-cap')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ]),

                        TextEntry::make('final_attrition_date')
                            ->label('Attrition Date')
                            ->date('F j, Y')
                            ->placeholder('Still employed')
                            ->visible(fn (CEMREmployee $record): bool => $record->final_attrition_date !== null),
                    ])
                    ->columns(2),

                Section::make('Organizational Structure')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('manager.full_name')
                                    ->label('Manager')
                                    ->placeholder('No manager assigned')
                                    ->weight(FontWeight::Medium),

                                TextEntry::make('supervisor.full_name')
                                    ->label('Supervisor')
                                    ->placeholder('No supervisor assigned')
                                    ->weight(FontWeight::Medium),
                            ]),
                    ])
                    ->columns(2),

                Section::make('Current Assignment')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('empService.rank.name')
                                    ->label('Rank')
                                    ->placeholder('Not assigned')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('empService.position.name')
                                    ->label('Position')
                                    ->placeholder('Not assigned')
                                    ->weight(FontWeight::Medium),

                                TextEntry::make('empService.project.name')
                                    ->label('Project')
                                    ->placeholder('Not assigned')
                                    ->weight(FontWeight::Medium),

                                TextEntry::make('empService.division.name')
                                    ->label('Division')
                                    ->placeholder('Not assigned')
                                    ->weight(FontWeight::Medium),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('empService.status.name')
                                    ->label('Employment Status')
                                    ->placeholder('Not assigned')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('empService.project_hired_date')
                                    ->label('Project Start Date')
                                    ->date('F j, Y')
                                    ->placeholder('Not provided'),
                            ]),

                        TextEntry::make('empService.comments')
                            ->label('Comments')
                            ->placeholder('No comments')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->columns(4)
                    ->visible(fn (CEMREmployee $record): bool => $record->empService !== null),

                Section::make('System Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Record Created')
                                    ->dateTime('F j, Y \a\t g:i A'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('F j, Y \a\t g:i A'),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
