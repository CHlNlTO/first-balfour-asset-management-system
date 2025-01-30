<?php

namespace App\Filament\App\Resources\AssignmentResource\Pages;

use App\Filament\App\Resources\AssignmentResource;
use App\Filament\App\Resources\AssignmentResource\Actions\ViewApprovalAction;
use App\Models\AssetStatus;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\HardwareType;
use App\Models\LicenseType;
use App\Models\Lifecycle;
use App\Models\PeripheralType;
use App\Models\SoftwareType;
use Filament\Infolists\Components\Group;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\FontWeight;

class ViewAssignment extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        Log::info('View Record View Data: ', $this->record->toArray());
        return $infolist
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Assignment Details')
                            ->schema([
                                TextEntry::make('asset.asset')
                                    ->label('Asset')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.id')
                                    ->label('Asset ID')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('employee.fullName')
                                    ->label('Emp. Name')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('employee.id_num')
                                    ->label('Emp. ID')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('status.assignment_status')
                                    ->label('Assignment Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        "Active" => "success",
                                        "Pending Approval" => "pending",
                                        "Pending Return" => "warning",
                                        "In Transfer" => "primary",
                                        "Transferred" => "success",
                                        "Declined" => "danger",
                                        'Unknown' => 'gray',
                                        default => 'gray',
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),

                            ])
                            ->icon('heroicon-o-clipboard-document')
                            ->columns(2),
                        Section::make('Hardware Details')
                            ->schema([
                                TextEntry::make('asset.hardware.hardwareType.hardware_type')
                                    ->label('Hardware Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.hardware.serial_number')
                                    ->label('Serial No.')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.hardware.specifications')
                                    ->label('Specifications')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.hardware.manufacturer')
                                    ->label('Manufacturer')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.hardware.warranty_expiration')
                                    ->label('Warranty Expiration Date')
                                    ->weight(FontWeight::Bold)
                                    ->date('M d, Y')
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                            ])
                            ->visible(function ($record): bool {
                                return $record->asset && $record->asset->asset_type === 'hardware';
                            })
                            ->icon('heroicon-o-computer-desktop')
                            ->columns(2),
                        Section::make('Software Details')
                            ->schema([
                                TextEntry::make('asset.software.version')
                                    ->label('Version')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.software.license_key')
                                    ->label('License Key')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.software.softwareType.software_type')
                                    ->label('Software Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.software.licenseType.license_type')
                                    ->label('License Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                            ])
                            ->visible(function ($record): bool {
                                return $record->asset && $record->asset->asset_type === 'software';
                            })
                            ->icon('heroicon-o-cpu-chip')
                            ->columns(2),

                        Section::make('Peripherals Details')
                            ->schema([
                                TextEntry::make('asset.peripherals.peripheralsType.peripherals_type')
                                    ->label('Peripherals Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.peripherals.serial_number')
                                    ->label('Serial No.')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.peripherals.specifications')
                                    ->label('Specifications')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.peripherals.manufacturer')
                                    ->label('Manufacturer')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.peripherals.warranty_expiration')
                                    ->label('Warranty Expiration Date')
                                    ->weight(FontWeight::Bold)
                                    ->date('M d, Y')
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                            ])
                            ->visible(function ($record): bool {
                                return $record->asset && $record->asset->asset_type === 'peripherals';
                            })
                            ->icon('heroicon-o-squares-2x2')
                            ->columns(2),
                    ])->columnSpan(['lg' => 2]), // This Group takes 2 columns

                Group::make()
                    ->schema([
                        Section::make('Assignment Duration')
                            ->schema([
                                TextEntry::make('start_date')
                                    ->label('Start Date')
                                    ->date('M d, Y')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('end_date')
                                    ->label('End Date')
                                    ->date('M d, Y')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                            ])
                            ->icon('heroicon-o-calendar')
                            ->columns(1),
                        Section::make('Asset Details')
                            ->schema([
                                TextEntry::make('asset.asset_type')
                                    ->label('Asset Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.assetStatus.asset_status')
                                    ->label('Asset Status')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.model.brand.name')
                                    ->label('Brand')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.model.name')
                                    ->label('Model')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                            ])
                            ->icon('heroicon-o-clipboard-document-list')
                            ->columns(1),
                        Section::make('Asset Lifecycle Information')
                            ->schema([
                                TextEntry::make('asset.lifecycle.acquisition_date')
                                    ->label('Acquisition')
                                    ->date('M d, Y')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.lifecycle.retirement_date')
                                    ->label('Retirement')
                                    ->date('M d, Y')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                            ])
                            ->icon('heroicon-o-clock')
                            ->columns(1),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns([
                'lg' => 3
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewApprovalAction::make(),
        ];
    }
}
