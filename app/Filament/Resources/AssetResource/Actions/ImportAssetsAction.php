<?php

namespace App\Filament\Resources\AssetResource\Actions;

use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Peripheral;
use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Lifecycle;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;

class ImportAssetsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'import_assets';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Import CSV')
            ->color('primary')
            ->action(function (array $data): void {
                $this->process($data['csv_file']);
            })
            ->form([
                \Filament\Forms\Components\FileUpload::make('csv_file')
                    ->label('CSV File')
                    ->acceptedFileTypes(['text/csv'])
                    ->required(),
            ])
            ->extraModalFooterActions([
                Action::make('download_example')
                    ->label('Download Example CSV')
                    ->color('secondary')
                    ->action(function () {
                        return response()->streamDownload(function () {
                            echo $this->generateExampleCsv();
                        }, 'example_assets_import.csv');
                    }),
            ]);
    }

    protected function generateExampleCsv(): string
    {
        $csv = Writer::createFromString('');

        $csv->insertOne([
            'asset_type',
            'asset_status',
            'model_id',
            'cost_code',
            'acquisition_date',
            'retirement_date',
            'purchase_order_no',
            'sales_invoice_no',
            'purchase_order_date',
            'purchase_order_amount',
            'requestor',
            'hardware_type',
            'serial_number',
            'specifications',
            'manufacturer',
            'warranty_expiration',
            'mac_address',
            'accessories',
            'pc_name_id',
            'version',
            'license_key',
            'software_type',
            'license_type',
            'peripherals_type',
            'vendor_id',
            'vendor_name',
            'vendor_address_1',
            'vendor_address_2',
            'vendor_city',
            'vendor_tel_no_1',
            'vendor_tel_no_2',
            'vendor_contact_person',
            'vendor_mobile_number',
            'vendor_email',
            'vendor_url',
            'vendor_remarks'
        ]);

        $csv->insertOne([
            'hardware',
            '1',
            '1',
            '1',
            '2023-01-01',
            '2028-01-01',
            'PO123',
            'INV456',
            '2023-01-01',
            '1500.00',
            'John Doe',
            '1',
            'SN12345',
            '16GB RAM, 512GB SSD',
            'Dell',
            '2025-12-31',
            '00:11:22:33:44:55',
            'Mouse, Keyboard',
            '1',
            '',
            '',
            '',
            '',
            '',
            '',
            'Dell Inc.',
            '123 Dell Way',
            '',
            'Round Rock',
            '1234567890',
            '',
            'Jane Smith',
            '9876543210',
            'jane@dell.com',
            'www.dell.com',
            'Preferred vendor'
        ]);

        $csv->insertOne([
            'software',
            '1',
            '4',
            '2',
            '2023-02-01',
            '2024-02-01',
            'PO789',
            'INV101',
            '2023-02-01',
            '300.00',
            'Jane Smith',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '2',
            '2021',
            'XXXX-XXXX-XXXX-XXXX',
            '1',
            '1',
            '',
            '1',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ]);

        $csv->insertOne([
            'peripherals',
            '1',
            '8',
            '3',
            '2023-03-01',
            '2026-03-01',
            'PO202',
            'INV303',
            '2023-03-01',
            '100.00',
            'Bob Johnson',
            '',
            'LGT123456',
            'Wireless Mouse',
            'Logitech',
            '2024-03-01',
            '',
            '',
            '3',
            '',
            '',
            '',
            '',
            '1',
            '',
            'Logitech Inc.',
            '7700 Gateway Blvd',
            '',
            'Newark',
            '5105795000',
            '',
            'Sarah Brown',
            '9876543210',
            'sarah@logitech.com',
            'www.logitech.com',
            'Peripheral supplier'
        ]);

        return $csv->toString();
    }

    protected function process($file): void
    {
        // Get the path to the uploaded file
        $path = Storage::disk('local')->path($file);

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                $this->createSingleAsset($record);
            }

            DB::commit();

            Notification::make()
                ->title('Assets imported successfully')
                ->success()
                ->send();
        } catch (\Exception $e) {
            DB::rollBack();

            Notification::make()
                ->title('Import failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function createSingleAsset(array $data): Asset
    {
        $validator = Validator::make($data, [
            'asset_type' => 'required|in:hardware,software,peripherals',
            'asset_status' => 'required|exists:asset_statuses,id',
            'model_id' => 'required|string',
            'cost_code' => 'nullable|string',
            'acquisition_date' => 'required|date',
            'retirement_date' => 'nullable|date',
            'purchase_order_no' => 'required|string',
            'sales_invoice_no' => 'required|string',
            'purchase_order_date' => 'required|date',
            'purchase_order_amount' => 'required|numeric',
            'requestor' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . $validator->errors()->first());
        }

        $asset = Asset::create($validator->validated());

        Lifecycle::create([
            'asset_id' => $asset->id,
            'acquisition_date' => $data['acquisition_date'],
            'retirement_date' => $data['retirement_date'] ?? null,
        ]);

        $vendorId = $this->handleVendor($data);

        Purchase::create([
            'asset_id' => $asset->id,
            'purchase_order_no' => $data['purchase_order_no'],
            'sales_invoice_no' => $data['sales_invoice_no'],
            'purchase_order_date' => $data['purchase_order_date'],
            'purchase_order_amount' => $data['purchase_order_amount'],
            'requestor' => $data['requestor'] ?? null,
            'vendor_id' => $vendorId,
        ]);

        switch ($data['asset_type']) {
            case 'hardware':
                $this->createHardware($asset, $data);
                break;
            case 'software':
                $this->createSoftware($asset, $data);
                break;
            case 'peripherals':
                $this->createPeripheral($asset, $data);
                break;
        }

        return $asset;
    }

    protected function createHardware(Asset $asset, array $data): void
    {
        $validator = Validator::make($data, [
            'hardware_type' => 'required|exists:hardware_types,id',
            'serial_number' => 'required|string',
            'specifications' => 'required|string',
            'manufacturer' => 'required|string',
            'warranty_expiration' => 'nullable|date',
            'mac_address' => 'nullable|string',
            'accessories' => 'nullable|string',
            'pc_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Hardware validation failed: ' . $validator->errors()->first());
        }

        Hardware::create(array_merge($validator->validated(), ['asset_id' => $asset->id]));
    }

    protected function createSoftware(Asset $asset, array $data): void
    {
        $validator = Validator::make($data, [
            'version' => 'required|string',
            'license_key' => 'required|string',
            'software_type' => 'required|exists:software_types,id',
            'license_type' => 'required|exists:license_types,id',
            'pc_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Software validation failed: ' . $validator->errors()->first());
        }

        Software::create(array_merge($validator->validated(), ['asset_id' => $asset->id]));
    }

    protected function createPeripheral(Asset $asset, array $data): void
    {
        $validator = Validator::make($data, [
            'peripherals_type' => 'required|exists:peripherals_types,id',
            'serial_number' => 'required|string',
            'specifications' => 'required|string',
            'manufacturer' => 'required|string',
            'warranty_expiration' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Peripheral validation failed: ' . $validator->errors()->first());
        }

        Peripheral::create(array_merge($validator->validated(), ['asset_id' => $asset->id]));
    }

    protected function handleVendor(array $data): int
    {
        // Check if vendor_id is provided and exists
        if (!empty($data['vendor_id'])) {
            $vendor = Vendor::find($data['vendor_id']);
            if ($vendor) {
                return $vendor->id;
            }
        }

        // If vendor_id is not provided or doesn't exist, check vendor details
        $vendorData = [
            'name' => $data['vendor_name'] ?? null,
            'address_1' => $data['vendor_address_1'] ?? null,
            'address_2' => $data['vendor_address_2'] ?? null,
            'city' => $data['vendor_city'] ?? null,
            'tel_no_1' => $data['vendor_tel_no_1'] ?? null,
            'tel_no_2' => $data['vendor_tel_no_2'] ?? null,
            'contact_person' => $data['vendor_contact_person'] ?? null,
            'mobile_number' => $data['vendor_mobile_number'] ?? null,
            'email' => $data['vendor_email'] ?? null,
            'url' => $data['vendor_url'] ?? null,
            'remarks' => $data['vendor_remarks'] ?? null,
        ];

        // Remove null values
        $vendorData = array_filter($vendorData, function ($value) {
            return !is_null($value);
        });

        if (empty($vendorData['name'])) {
            throw new \Exception('Vendor name is required when vendor_id is not provided or invalid.');
        }

        $vendor = Vendor::firstOrCreate(
            ['name' => $vendorData['name']],
            $vendorData
        );

        return $vendor->id;
    }
}
