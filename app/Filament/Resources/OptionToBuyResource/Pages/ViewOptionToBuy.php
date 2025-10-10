<?php

namespace App\Filament\Resources\OptionToBuyResource\Pages;

use App\Filament\Resources\OptionToBuyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Actions\Action as InfolistAction;

class ViewOptionToBuy extends ViewRecord
{
    protected static string $resource = OptionToBuyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('downloadDocument')
                ->label('Download Document')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn($record) => $record->document_url)
                ->openUrlInNewTab()
                ->visible(fn($record) => $record->document_path !== null),
        ];
    }

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
                            ->url(fn($record) => route('filament.admin.resources.assignments.view', ['record' => $record->assignment_id]))
                            ->weight(FontWeight::Bold),
                        TextEntry::make('employee')
                            ->label('Employee')
                            ->getStateUsing(fn($record) => $record->assignment->employee->first_name . ' ' . $record->assignment->employee->last_name)
                            ->url(fn($record) => route('filament.admin.resources.employees.view', ['record' => $record->assignment->employee->id_num]))
                            ->weight(FontWeight::Bold),
                        TextEntry::make('asset')
                            ->label('Asset')
                            ->getStateUsing(function($record) {
                                $asset = $record->assignment->asset;
                                if (!$asset) return 'N/A';
                                $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                                $model = $asset->model?->name ?? 'Unknown Model';
                                return "{$brand} {$model}";
                            })
                            ->url(fn($record) => route('filament.admin.resources.assets.view', ['record' => $record->assignment->asset_id]))
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

                Section::make('Document')
                    ->schema([
                        ImageEntry::make('document_path')
                            ->label('Document')
                            ->disk('public')
                            ->visible(function ($record) {
                                // Only display as image if it's an image file
                                if (!$record->document_path) return false;
                                $extension = pathinfo($record->document_path, PATHINFO_EXTENSION);
                                return in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                            })
                            ->url(fn($record) => $record->document_url)
                            ->openUrlInNewTab(),

                        TextEntry::make('document_path')
                            ->label('Document')
                            ->formatStateUsing(function ($state) {
                                if (!$state) return 'No document attached';

                                $extension = pathinfo($state, PATHINFO_EXTENSION);
                                if (strtolower($extension) === 'pdf') {
                                    return 'PDF Document';
                                }

                                return 'Document';
                            })
                            ->visible(function ($record) {
                                // Only display as text for PDF or when no document
                                if (!$record->document_path) return true;
                                $extension = pathinfo($record->document_path, PATHINFO_EXTENSION);
                                return strtolower($extension) === 'pdf' || !in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                            })
                            ->url(fn($record) => $record->document_url)
                            ->openUrlInNewTab()
                            ->hidden(fn($record) => !$record->document_path &&
                                in_array(pathinfo($record->document_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])),
                    ])
                    ->collapsible()
                    ->hidden(fn($record) => !$record->document_path),
            ]);
    }
}
