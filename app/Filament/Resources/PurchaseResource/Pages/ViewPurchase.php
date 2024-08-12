<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\HardwareType;
use App\Models\SoftwareType;
use App\Models\LicenseType;
use App\Models\PeripheralType;
use App\Models\AssetStatus;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Repeater;
use Illuminate\Support\Facades\Log;

class ViewPurchase extends ViewRecord
{
    protected static string $resource = PurchaseResource::class;

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
                Section::make('Purchase Information')
                    ->schema([
                        TextEntry::make('purchase_order_no')
                            ->label('Purchase Order No.'),
                        TextEntry::make('sales_invoice_no')
                            ->label('Sales Invoice No.'),
                        TextEntry::make('purchase_order_date')
                            ->label('Purchase Order Date')
                            ->date(),
                        TextEntry::make('purchase_order_amount')
                            ->label('Purchase Order Amount')
                            ->money('php'),
                        TextEntry::make('requestor')
                            ->label('Requestor')
                            ->placeholder('N/A'),
                    ])
                    ->columns(2),

                Section::make('Vendor Information')
                    ->schema([
                        TextEntry::make('vendor.name')
                            ->label('Vendor Name'),
                        TextEntry::make('vendor.address_1')
                            ->label('Address 1'),
                        TextEntry::make('vendor.address_2')
                            ->label('Address 2'),
                        TextEntry::make('vendor.city')
                            ->label('City'),
                        TextEntry::make('vendor.tel_no_1')
                            ->label('Telephone No. 1'),
                        TextEntry::make('vendor.tel_no_2')
                            ->label('Telephone No. 2'),
                        TextEntry::make('vendor.contact_person')
                            ->label('Contact Person'),
                        TextEntry::make('vendor.mobile_number')
                            ->label('Mobile Number'),
                        TextEntry::make('vendor.email')
                            ->label('Email'),
                        TextEntry::make('vendor.url')
                            ->label('URL'),
                        TextEntry::make('vendor.remarks')
                            ->label('Remarks'),
                    ])
                    ->columns(2),
            ]);
    }
}
