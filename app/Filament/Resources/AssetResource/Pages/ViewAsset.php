<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Repeater;
use Illuminate\Support\Facades\Log;

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
                Section::make('Asset Details')
                    ->schema([
                        TextEntry::make('asset_type')
                            ->label('Asset Type'),
                        TextEntry::make('asset_status')
                            ->label('Asset Status'),
                        TextEntry::make('brand')
                            ->label('Brand'),
                        TextEntry::make('model')
                            ->label('Model'),
                    ])
                    ->columns(2),

                Section::make('Hardware Details')
                    ->schema([
                        TextEntry::make('hardware.specifications')
                            ->label('Specifications'),
                        TextEntry::make('hardware.serial_number')
                            ->label('Serial No.'),
                        TextEntry::make('hardware.manufacturer')
                            ->label('Manufacturer'),
                        TextEntry::make('hardware.warranty_expiration')
                            ->label('Warranty Expiration Date')
                            ->date(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->asset_type === 'hardware'),

                Section::make('Software Details')
                    ->schema([
                        TextEntry::make('software.version')
                            ->label('Version'),
                        TextEntry::make('software.license_key')
                            ->label('License Key'),
                        TextEntry::make('software.license_type')
                            ->label('License Type'),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->asset_type === 'software'),

                Section::make('Peripherals Details')
                    ->schema([
                        TextEntry::make('peripherals.specifications')
                            ->label('Specifications'),
                        TextEntry::make('peripherals.serial_number')
                            ->label('Serial No.'),
                        TextEntry::make('peripherals.manufacturer')
                            ->label('Manufacturer'),
                        TextEntry::make('peripherals.warranty_expiration')
                            ->label('Warranty Expiration Date')
                            ->date(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->asset_type === 'peripherals'),

                Section::make('Lifecycle Information')
                    ->schema([
                        TextEntry::make('lifecycle.acquisition_date')
                            ->label('Acquisition Date')
                            ->date(),
                        TextEntry::make('lifecycle.retirement_date')
                            ->label('Retirement Date')
                            ->date(),
                    ])
                    ->columns(2),

                Section::make('Purchase Information')
                    ->schema([
                        TextEntry::make('purchases.purchase_order_no')
                            ->label('Purchase Order No.'),
                        TextEntry::make('purchases.receipt_no')
                            ->label('Sales Invoice No.'),
                        TextEntry::make('purchases.purchase_date')
                            ->label('Purchase Order Date')
                            ->date(),
                        TextEntry::make('purchases.purchase_cost')
                            ->label('Purchase Order Amount')
                            ->money('php'),
                    ])
                    ->columns(2),

                Section::make('Vendor Information')
                    ->schema([
                        TextEntry::make('purchases.vendor.name')
                            ->label('Vendor Name'),
                        TextEntry::make('purchases.vendor.address_1')
                            ->label('Address 1'),
                        TextEntry::make('purchases.vendor.address_2')
                            ->label('Address 2'),
                        TextEntry::make('purchases.vendor.city')
                            ->label('City'),
                        TextEntry::make('purchases.vendor.tel_no_1')
                            ->label('Telephone No. 1'),
                        TextEntry::make('purchases.vendor.tel_no_2')
                            ->label('Telephone No. 2'),
                        TextEntry::make('purchases.vendor.contact_person')
                            ->label('Contact Person'),
                        TextEntry::make('purchases.vendor.mobile_number')
                            ->label('Mobile Number'),
                        TextEntry::make('purchases.vendor.email')
                            ->label('Email'),
                        TextEntry::make('purchases.vendor.url')
                            ->label('URL'),
                        TextEntry::make('purchases.vendor.remarks')
                            ->label('Remarks'),
                    ])
                    ->columns(2),
            ]);
    }
}