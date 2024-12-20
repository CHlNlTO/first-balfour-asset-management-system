<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use App\Models\Asset;
use App\Models\HardwareType;
use App\Models\SoftwareType;
use App\Models\LicenseType;
use App\Models\PeripheralType;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\Log;
use Filament\Support\Enums\FontWeight;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        Log::info('Initial Record View Data: ', $this->record->toArray());

        return $infolist
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Asset Details')
                            ->schema([
                                TextEntry::make('brand')
                                    ->label('Brand')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('model')
                                    ->label('Model')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('asset_type')
                                    ->label('Asset Type')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('asset_status')
                                    ->label('Asset Status')
                                    ->getStateUsing(function ($record) {
                                        Log::info('Record:', ['record' => $record->toArray()]);
                                        Log::info('Asset Status:', ['asset_status' => $record->assetStatus]);

                                        return optional($record->assetStatus)->asset_status ?? 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->badge()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('department_project_code')
                                    ->label('Department/Project Code')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                            ])
                            ->columns(2),


                        Section::make('Hardware Details')
                            ->schema([
                                TextEntry::make('hardware_type')
                                    ->label('Hardware Type')
                                    ->getStateUsing(function ($record): string {
                                        $hardware = $record->hardware;
                                        $hardwareType = HardwareType::find($hardware->hardware_type ?? null);
                                        return $hardwareType ? $hardwareType->hardware_type : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.serial_number')
                                    ->label('Serial No.')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.specifications')
                                    ->label('Specifications')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.manufacturer')
                                    ->label('Manufacturer')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.mac_address')
                                    ->label('MAC Address')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.accessories')
                                    ->label('Accessories')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.pc_name')
                                    ->label('PC Name')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('hardware.warranty_expiration')
                                    ->label('Warranty Expiration Date')
                                    ->date()
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                            ])
                            ->columns(2)
                            ->visible(fn($record) => $record->asset_type === 'hardware'),

                        // Section::make('Attached Software')
                        //     ->schema([
                        //         RepeatableEntry::make('hardware.software')
                        //             ->schema([
                        //                 TextEntry::make('asset.brand')
                        //                     ->label('Brand')
                        //                     ->getStateUsing(function ($record) {
                        //                         // $record here is the Software model
                        //                         return Asset::find($record->asset_id)->brand ?? 'N/A';
                        //                     })
                        //                     ->weight(FontWeight::Bold),
                        //                 TextEntry::make('asset.model')
                        //                     ->label('Model')
                        //                     ->getStateUsing(function ($record) {
                        //                         return Asset::find($record->asset_id)->model ?? 'N/A';
                        //                     })
                        //                     ->weight(FontWeight::Bold),
                        //                 TextEntry::make('version')
                        //                     ->label('Version')
                        //                     ->weight(FontWeight::Bold),
                        //                 TextEntry::make('license_key')
                        //                     ->label('License Key')
                        //                     ->weight(FontWeight::Bold),
                        //             ])
                        //             ->columns(2)
                        //     ])
                        //     ->visible(fn($record) => $record->asset_type === 'hardware'), // Only show for hardware assets

                        Section::make('Software Details')
                            ->schema([
                                TextEntry::make('software.version')
                                    ->label('Version')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('software.license_key')
                                    ->label('License Key')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('software_type')
                                    ->label('Software Type')
                                    ->getStateUsing(function ($record): string {
                                        $software = $record->software;
                                        $softwareType = SoftwareType::find($software->software_type ?? null);
                                        return $softwareType ? $softwareType->software_type : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('license_type')
                                    ->label('License Type')
                                    ->getStateUsing(function ($record): string {
                                        $software = $record->software;
                                        $licenseType = LicenseType::find($software->license_type ?? null);
                                        return $licenseType ? $licenseType->license_type : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('software.pc_name')
                                    ->label('PC Name')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                            ])
                            ->columns(2)
                            ->visible(fn($record) => $record->asset_type === 'software'),

                        Section::make('Peripherals Details')
                            ->schema([
                                TextEntry::make('peripherals_type')
                                    ->label('Peripheral Type')
                                    ->getStateUsing(function ($record): string {
                                        $peripheral = $record->peripherals;
                                        $peripheralType = PeripheralType::find($peripheral->peripherals_type ?? null);
                                        return $peripheralType ? $peripheralType->peripherals_type : 'N/A';
                                    })
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('peripherals.serial_number')
                                    ->label('Serial No.')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('peripherals.specifications')
                                    ->label('Specifications')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('peripherals.manufacturer')
                                    ->label('Manufacturer')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('peripherals.warranty_expiration')
                                    ->label('Warranty Expiration Date')
                                    ->date()
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                            ])
                            ->columns(2)
                            ->visible(fn($record) => $record->asset_type === 'peripherals'),
                    ])->columnSpan(['lg' => 5]),
                Group::make()
                    ->schema([
                        Section::make('Lifecycle Information')
                            ->schema([
                                TextEntry::make('lifecycle.acquisition_date')
                                    ->label('Acquired Date')
                                    ->date()
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                                TextEntry::make('lifecycle.retirement_date')
                                    ->label('Retirement Date')
                                    ->date()
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20)
                                    ->tooltip(function (TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                        return $state;
                                    }),
                            ])
                            ->columns(2),

                        Section::make('Purchase Information')
                            ->schema([
                                TextEntry::make('purchases.purchase_order_no')
                                    ->label('PO. No.')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.sales_invoice_no')
                                    ->label('SI. No.')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.purchase_order_date')
                                    ->label('PO. Date')
                                    ->date()
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.purchase_order_amount')
                                    ->label('PO. Cost')
                                    ->money('php')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                            ])
                            ->columns(2),

                        Section::make('Vendor Information')
                            ->schema([
                                TextEntry::make('purchases.vendor.name')
                                    ->label('Vendor Name')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.address_1')
                                    ->label('Address 1')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.address_2')
                                    ->label('Address 2')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.city')
                                    ->label('City')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.tel_no_1')
                                    ->label('Telephone No. 1')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.tel_no_2')
                                    ->label('Telephone No. 2')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.contact_person')
                                    ->label('Contact Person')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.mobile_number')
                                    ->label('Mobile Number')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.email')
                                    ->label('Email')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.url')
                                    ->label('URL')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                                TextEntry::make('purchases.vendor.remarks')
                                    ->label('Remarks')
                                    ->weight(FontWeight::Bold)
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1000)
                                    ->placeholder('N/A')
                                    ->inlineLabel()
                                    ->limit(20),
                            ])
                            ->columns(2),
                    ])->columnSpan(['lg' => 3]),
            ])
            ->columns([
                'lg' => 8
            ]);;
    }
}
