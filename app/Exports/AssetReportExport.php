<?php

namespace App\Exports;

use App\Models\Assignment;
use App\Models\HardwareSoftware;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        try {
            return Assignment::with([
                'employee',
                'asset',
                'asset.hardware',
                'asset.software',
                'asset.peripherals',
                'asset.costCode',
                'asset.model.brand',
                'asset.lifecycle',
                'asset.purchases.vendor',
                'status'
            ])->get();
        } catch (\Exception $e) {
            // Return empty collection if there's an error
            return collect([]);
        }
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Employee Full Name',
            'Tag Number',
            'Asset Name (Brand and Model)',
            'Assignment Status',
            'Cost Code',
            'Hardware/Software/Peripherals Details',
            'Attached Software or Hardware Attached To',
            'Lifecycle Information',
            'Purchase Details',
            'Vendor Details'
        ];
    }

        public function map($assignment): array
    {
        try {
            $asset = $assignment->asset;
            $employee = $assignment->employee;

            // Get asset details based on type
            $assetDetails = $this->getAssetDetails($asset);
            $attachedItems = $this->getAttachedItems($asset);

            return [
                $employee ? $employee->id_num : 'N/A',
                $employee ? $employee->full_name : 'N/A',
                $asset ? $asset->tag_number : 'N/A',
                $assetDetails['name'] ?? 'N/A',
                $assignment->status ? $assignment->status->assignment_status : 'N/A',
                $asset && $asset->costCode ? $asset->costCode->name : 'N/A',
                $assetDetails['details'] ?? 'N/A',
                $attachedItems,
                $this->getLifecycleInfo($asset),
                $this->getPurchaseDetails($asset),
                $this->getVendorDetails($asset)
            ];
        } catch (\Exception $e) {
            // Return array with error information if mapping fails
            return [
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error',
                'Error'
            ];
        }
    }

    private function getAssetDetails($asset)
    {
        if (!$asset) return ['name' => 'N/A', 'details' => 'N/A'];

                if ($asset->hardware) {
            $hardware = $asset->hardware;
            $model = $asset->model;
            $brand = $model ? $model->brand : null;

            return [
                'name' => ($brand ? $brand->name . ' ' : '') . ($model ? $model->name : ''),
                'details' => $this->formatHardwareDetails($hardware)
            ];
        }

        if ($asset->software) {
            $software = $asset->software;
            $model = $asset->model;
            $brand = $model ? $model->brand : null;

            return [
                'name' => ($brand ? $brand->name . ' ' : '') . ($model ? $model->name : ''),
                'details' => $this->formatSoftwareDetails($software)
            ];
        }

                if ($asset->peripherals) {
            $peripheral = $asset->peripherals;
            $model = $asset->model;
            $brand = $model ? $model->brand : null;

            return [
                'name' => ($brand ? $brand->name . ' ' : '') . ($model ? $model->name : ''),
                'details' => $this->formatPeripheralDetails($peripheral)
            ];
        }

        return ['name' => 'N/A', 'details' => 'N/A'];
    }

    private function formatHardwareDetails($hardware)
    {
        $details = [];
        if ($hardware->serial_number) $details[] = "SN: {$hardware->serial_number}";
        if ($hardware->specifications) $details[] = "Specs: {$hardware->specifications}";
        if ($hardware->manufacturer) $details[] = "Manufacturer: {$hardware->manufacturer}";
        if ($hardware->mac_address) $details[] = "MAC: {$hardware->mac_address}";
        if ($hardware->accessories) $details[] = "Accessories: {$hardware->accessories}";
        if ($hardware->warranty_expiration) $details[] = "Warranty: {$hardware->warranty_expiration}";

        return implode(', ', $details);
    }

    private function formatSoftwareDetails($software)
    {
        $details = [];
        if ($software->version) $details[] = "Version: {$software->version}";
        if ($software->license_key) $details[] = "License: {$software->license_key}";
        if ($software->softwareType) $details[] = "Type: {$software->softwareType->software_type}";
        if ($software->licenseType) $details[] = "License Type: {$software->licenseType->license_type}";

        return implode(', ', $details);
    }

    private function formatPeripheralDetails($peripheral)
    {
        $details = [];
        if ($peripheral->serial_number) $details[] = "SN: {$peripheral->serial_number}";
        if ($peripheral->specifications) $details[] = "Specs: {$peripheral->specifications}";
        if ($peripheral->manufacturer) $details[] = "Manufacturer: {$peripheral->manufacturer}";
        if ($peripheral->peripheralType) $details[] = "Type: {$peripheral->peripheralType->peripheral_type}";

        return implode(', ', $details);
    }

    private function getAttachedItems($asset)
    {
        if (!$asset) return 'N/A';

        $attached = [];

                if ($asset->hardware) {
            // Get software attached to this hardware
            $attachedSoftware = HardwareSoftware::where('hardware_asset_id', $asset->id)
                ->with('software.model.brand')
                ->get();

            foreach ($attachedSoftware as $hwSw) {
                if ($hwSw->software) {
                    $brand = $hwSw->software->model ? $hwSw->software->model->brand : null;
                    $model = $hwSw->software->model;
                    $name = ($brand ? $brand->name . ' ' : '') . ($model ? $model->name : '');
                    $attached[] = "Software: {$name}";
                }
            }
        }

        if ($asset->software) {
            // Get hardware this software is attached to
            $attachedHardware = HardwareSoftware::where('software_asset_id', $asset->id)
                ->with('hardware.model.brand')
                ->get();

            foreach ($attachedHardware as $hwSw) {
                if ($hwSw->hardware) {
                    $brand = $hwSw->hardware->model ? $hwSw->hardware->model->brand : null;
                    $model = $hwSw->hardware->model;
                    $name = ($brand ? $brand->name . ' ' : '') . ($model ? $model->name : '');
                    $attached[] = "Hardware: {$name}";
                }
            }
        }

        return empty($attached) ? 'None' : implode('; ', $attached);
    }

    private function getLifecycleInfo($asset)
    {
        if (!$asset || !$asset->lifecycle) return 'N/A';

        $lifecycle = $asset->lifecycle;
        $info = [];

        if ($lifecycle->acquisition_date) $info[] = "Acquired: {$lifecycle->acquisition_date}";
        if ($lifecycle->retirement_date) $info[] = "Retires: {$lifecycle->retirement_date}";
        if ($lifecycle->lifecycle_status) $info[] = "Status: {$lifecycle->lifecycle_status}";

        return implode(', ', $info);
    }

        private function getPurchaseDetails($asset)
    {
        if (!$asset || !$asset->purchases || $asset->purchases->isEmpty()) return 'N/A';

        $purchase = $asset->purchases->first();
        $details = [];

        if ($purchase->purchase_order_no) $details[] = "PO: {$purchase->purchase_order_no}";
        if ($purchase->sales_invoice_no) $details[] = "Invoice: {$purchase->sales_invoice_no}";
        if ($purchase->purchase_order_date) $details[] = "Date: {$purchase->purchase_order_date}";
        if ($purchase->purchase_order_amount) $details[] = "Amount: {$purchase->purchase_order_amount}";
        if ($purchase->requestor) $details[] = "Requestor: {$purchase->requestor}";

        return implode(', ', $details);
    }

    private function getVendorDetails($asset)
    {
        if (!$asset || !$asset->purchases || $asset->purchases->isEmpty() || !$asset->purchases->first()->vendor) return 'N/A';

        $vendor = $asset->purchases->first()->vendor;
        $details = [];

        if ($vendor->vendor_name) $details[] = "Name: {$vendor->vendor_name}";
        if ($vendor->vendor_address_1) $details[] = "Address: {$vendor->vendor_address_1}";
        if ($vendor->vendor_city) $details[] = "City: {$vendor->vendor_city}";
        if ($vendor->vendor_tel_no_1) $details[] = "Tel: {$vendor->vendor_tel_no_1}";
        if ($vendor->vendor_email) $details[] = "Email: {$vendor->vendor_email}";

        return implode(', ', $details);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ]
        ];
    }
}
