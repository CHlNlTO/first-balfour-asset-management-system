<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use App\Models\Asset;
use App\Models\AssetStatus;
use App\Models\Assignment;
use App\Models\Purchase;
use App\Models\Lifecycle;
use App\Models\Vendor;
use App\Models\AssignmentStatus;
use App\Models\Employee;
use App\Models\HardwareType;
use App\Models\SoftwareType;
use App\Models\LicenseType;
use App\Models\PeripheralType;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\DateTimeEntry;
use Filament\Infolists\Components\Group;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\FontWeight;

class ViewAssignment extends ViewRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

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
                                        if (!$asset) return 'N/A';
                                        $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                                        // For software, only show brand
                                        if ($asset->asset_type === 'software') {
                                            return $brand;
                                        }
                                        // For hardware/peripherals, show brand + model
                                        $model = $asset->model?->name ?? 'Unknown Model';
                                        return "{$brand} {$model}";
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.tag_number')
                                    ->label('Tag Number')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('employee.full_name')
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
                                    ->color(fn($record) => $record->status?->color?->getColor())
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
                                TextEntry::make('asset.software.software_type')
                                    ->label('Software Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel(),
                                TextEntry::make('asset.software.license_type')
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
                                TextEntry::make('asset.peripherals.peripherals_type')
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
                                    ->badge()
                                    ->color(fn($record) => $record->asset->assetStatus?->color?->getColor())
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
}
