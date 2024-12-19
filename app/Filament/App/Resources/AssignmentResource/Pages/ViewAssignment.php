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
                                TextEntry::make('asset.brand')
                                    ->label('Asset')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $asset = $record->asset;
                                        return $asset ? "{$asset->brand} {$asset->model}" : 'N/A';
                                    })
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
                                TextEntry::make('full_name')
                                    ->label('Emp. Name')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $employee = $record->employee;
                                        return $employee ? "{$employee->getFullName()}" : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('employee_id')
                                    ->label('Emp. ID')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $employee = $record->employee;
                                        return $employee ? "{$employee->id_num}" : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('assignment_status')
                                    ->label('Assignment Status')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $assignmentStatus = AssignmentStatus::find($record->assignment_status);
                                        return $assignmentStatus ? $assignmentStatus->assignment_status : 'N/A';
                                    })
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
                                TextEntry::make('hardware_type')
                                    ->label('Hardware Type')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset && $record->asset->hardware) {
                                            $hardwareType = HardwareType::find($record->asset->hardware->hardware_type);
                                            return $hardwareType ? $hardwareType->hardware_type : 'N/A';
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('serial_number')
                                    ->label('Serial No.')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->hardware) {
                                                return $record->asset->hardware->serial_number ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('specifications')
                                    ->label('Specifications')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->hardware) {
                                                return $record->asset->hardware->specifications ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('manufacturer')
                                    ->label('Manufacturer')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->hardware) {
                                                return $record->asset->hardware->manufacturer ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('warranty_expiration')
                                    ->label('Warranty Expiration Date')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->hardware) {
                                                return $record->asset->hardware->warranty_expiration ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
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
                                TextEntry::make('software.version')
                                    ->label('Version')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->software) {
                                                return $record->asset->software->version ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('software.license_key')
                                    ->label('License Key')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->software) {
                                                return $record->asset->software->license_key ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('software_type')
                                    ->label('Software Type')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset && $record->asset->software) {
                                            $softwareType = SoftwareType::find($record->asset->software->software_type);
                                            return $softwareType ? $softwareType->software_type : 'N/A';
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('license_type')
                                    ->label('License Type')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset && $record->asset->software) {
                                            $licenseType = LicenseType::find($record->asset->software->license_type);
                                            return $licenseType ? $licenseType->license_type : 'N/A';
                                        }
                                        return 'N/A';
                                    })
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
                                TextEntry::make('peripherals_type')
                                    ->label('Peripherals Type')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset && $record->asset->peripherals) {
                                            $peripheralsType = PeripheralType::find($record->asset->peripherals->peripherals_type);
                                            return $peripheralsType ? $peripheralsType->peripherals_type : 'N/A';
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('serial_number')
                                    ->label('Serial No.')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->peripherals) {
                                                return $record->asset->peripherals->serial_number ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('specifications')
                                    ->label('Specifications')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->peripherals) {
                                                return $record->asset->peripherals->specifications ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('manufacturer')
                                    ->label('Manufacturer')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->peripherals) {
                                                return $record->asset->peripherals->manufacturer ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('warranty_expiration')
                                    ->label('Warranty Expiration Date')
                                    ->getStateUsing(function (Assignment $record): string {
                                        if ($record->asset) {
                                            if ($record->asset->peripherals) {
                                                return $record->asset->peripherals->warranty_expiration ?? 'N/A';
                                            }
                                        }
                                        return 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
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
                                    ->getStateUsing(function (Assignment $record): string {
                                        $startDate = Carbon::parse($record->start_date);
                                        return $startDate ? $startDate->format('m/d/Y') : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('end_date')
                                    ->label('End Date')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $endDate = Carbon::parse($record->end_date);
                                        return $endDate ? $endDate->format('m/d/Y') : 'N/A';
                                    })
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
                                TextEntry::make('asset.asset_status')
                                    ->label('Asset Status')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $assetStatus = AssetStatus::find($record->asset->asset_status);
                                        return $assetStatus ? $assetStatus->asset_status : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.brand')
                                    ->label('Brand')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.model')
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
                                TextEntry::make('acquisition_date')
                                    ->label('Acquisition')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $lifecycle = Lifecycle::where('asset_id', $record->asset->id)->first();
                                        return $lifecycle && $lifecycle->acquisition_date
                                            ? Carbon::parse($lifecycle->acquisition_date)->format('m/d/Y')
                                            : "N/A";
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('retirement_date')
                                    ->label('Retirement')
                                    ->getStateUsing(function (Assignment $record): string {
                                        $lifecycle = Lifecycle::where('asset_id', $record->asset->id)->first();
                                        return $lifecycle && $lifecycle->retirement_date
                                            ? Carbon::parse($lifecycle->retirement_date)->format('m/d/Y')
                                            : "N/A";
                                    })
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
