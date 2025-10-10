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
use Illuminate\Support\Facades\Log;

class AssetReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        try {
            return Assignment::with([
                'employee',
                'asset',
                'asset.model.brand',
                'asset.costCode',
                'status'
            ])->get();
        } catch (\Exception $e) {
            Log::error('Error in AssetReportExport collection: ' . $e->getMessage());
            return collect([]);
        }
    }

    public function headings(): array
    {
        return [
            // Employee Information
            'Employee ID',
            'Employee Full Name',

            // Asset Basic Information
            'Tag Number',
            'Asset Type',
            'Asset Name',
            'Brand',
            'Model',
            'Cost Code',
            'Assignment Status',
            'Assignment Receive Date',
            'Assignment Return Date',

            // Hardware Details
            'Hardware Type',
            'Hardware Serial Number',
            'Hardware Specifications',
            'Hardware Manufacturer',
            'Hardware MAC Address',
            'Hardware Accessories',
            'Hardware PC Name',

            // Software Details
            'Software Type',
            'Software Version',
            'Software License Key',
            'Software License Type',

            // Peripheral Details
            'Peripheral Type',
            'Peripheral Specifications',
            'Peripheral Manufacturer',

            // Lifecycle Information
            'Acquisition Date',
            'Retirement Date',
            'Lifecycle Status',

            // Purchase Information
            'Purchase Order Number',
            'Sales Invoice Number',
            'Purchase Order Date',
            'Purchase Cost',
            'Purchase Order Amount',
            'Requestor',

            // Vendor Information
            'Vendor Name',
            'Vendor Address 1',
            'Vendor Address 2',
            'Vendor City',
            'Vendor Telephone 1',
            'Vendor Telephone 2',
            'Vendor Contact Person',
            'Vendor Mobile Number',
            'Vendor Email',
            'Vendor URL',
            'Vendor Remarks'
        ];
    }

    public function map($assignment): array
    {
        try {
            $asset = $assignment->asset;
            $employee = $assignment->employee;

            if (!$asset) {
                Log::warning('Assignment ' . $assignment->id . ' has no asset');
                return $this->getEmptyRow();
            }

            // Get asset details based on type
            $assetDetails = $this->getAssetDetails($asset);

            return [
                // Employee Information
                $employee ? $employee->id_num : 'N/A',
                $employee ? $employee->full_name : 'N/A',

                // Asset Basic Information
                $asset->tag_number ?? 'N/A',
                $asset->asset_type ?? 'N/A',
                $assetDetails['name'] ?? 'N/A',
                $assetDetails['brand'] ?? 'N/A',
                $assetDetails['model'] ?? 'N/A',
                $asset && $asset->costCode ? $asset->costCode->name : 'N/A',
                $assignment->status ? $assignment->status->assignment_status : 'N/A',
                $assignment->start_date ? \Carbon\Carbon::parse($assignment->start_date)->toDateString() : 'N/A',
                $assignment->end_date ?? 'N/A',

                // Hardware Details
                $assetDetails['hardware_type'] ?? 'N/A',
                $assetDetails['hardware_serial_number'] ?? 'N/A',
                $assetDetails['hardware_specifications'] ?? 'N/A',
                $assetDetails['hardware_manufacturer'] ?? 'N/A',
                $assetDetails['hardware_mac_address'] ?? 'N/A',
                $assetDetails['hardware_accessories'] ?? 'N/A',
                $assetDetails['hardware_pc_name'] ?? 'N/A',

                // Software Details
                $assetDetails['software_type'] ?? 'N/A',
                $assetDetails['software_version'] ?? 'N/A',
                $assetDetails['software_license_key'] ?? 'N/A',
                $assetDetails['software_license_type'] ?? 'N/A',

                // Peripheral Details
                $assetDetails['peripheral_type'] ?? 'N/A',
                $assetDetails['peripheral_specifications'] ?? 'N/A',
                $assetDetails['peripheral_manufacturer'] ?? 'N/A',

                // Lifecycle Information
                $assetDetails['acquisition_date'] ?? 'N/A',
                $assetDetails['retirement_date'] ?? 'N/A',
                $assetDetails['lifecycle_status'] ?? 'N/A',

                // Purchase Information
                $assetDetails['purchase_order_no'] ?? 'N/A',
                $assetDetails['sales_invoice_no'] ?? 'N/A',
                $assetDetails['purchase_order_date'] ?? 'N/A',
                $assetDetails['purchase_cost'] ?? 'N/A',
                $assetDetails['purchase_order_amount'] ?? 'N/A',
                $assetDetails['requestor'] ?? 'N/A',

                // Vendor Information
                $assetDetails['vendor_name'] ?? 'N/A',
                $assetDetails['vendor_address_1'] ?? 'N/A',
                $assetDetails['vendor_address_2'] ?? 'N/A',
                $assetDetails['vendor_city'] ?? 'N/A',
                $assetDetails['vendor_tel_no_1'] ?? 'N/A',
                $assetDetails['vendor_tel_no_2'] ?? 'N/A',
                $assetDetails['vendor_contact_person'] ?? 'N/A',
                $assetDetails['vendor_mobile_number'] ?? 'N/A',
                $assetDetails['vendor_email'] ?? 'N/A',
                $assetDetails['vendor_url'] ?? 'N/A',
                $assetDetails['vendor_remarks'] ?? 'N/A'
            ];
        } catch (\Exception $e) {
            Log::error('Error mapping assignment ' . ($assignment->id ?? 'unknown') . ': ' . $e->getMessage());
            return $this->getEmptyRow();
        }
    }

    private function getAssetDetails($asset)
    {
        if (!$asset) return [];

        $details = [
            'name' => 'N/A',
            'brand' => 'N/A',
            'model' => 'N/A'
        ];

        try {
            // Get brand and model information
            if ($asset->model) {
                $details['model'] = $asset->model->name ?? 'N/A';
                if ($asset->model->brand) {
                    $details['brand'] = $asset->model->brand->name ?? 'N/A';
                    $details['name'] = ($asset->model->brand->name ?? '') . ' ' . ($asset->model->name ?? '');
                }
            }

            // Hardware details
            if ($asset->hardware) {
                $hardware = $asset->hardware;
                $details['hardware_type'] = $hardware->hardwareType ? $hardware->hardwareType->hardware_type : 'N/A';
                $details['hardware_serial_number'] = $hardware->serial_number ?? 'N/A';
                $details['hardware_specifications'] = $hardware->specifications ?? 'N/A';
                $details['hardware_manufacturer'] = $hardware->manufacturer ?? 'N/A';
                $details['hardware_mac_address'] = $hardware->mac_address ?? 'N/A';
                $details['hardware_accessories'] = $hardware->accessories ?? 'N/A';
                $details['hardware_pc_name'] = $hardware->pcName->name ?? 'N/A';
            }

            // Software details
            if ($asset->software) {
                $software = $asset->software;
                $details['software_type'] = $software->softwareType ? $software->softwareType->software_type : 'N/A';
                $details['software_version'] = $software->version ?? 'N/A';
                $details['software_license_key'] = $software->license_key ?? 'N/A';
                $details['software_license_type'] = $software->licenseType ? $software->licenseType->license_type : 'N/A';
            }

            // Peripheral details
            if ($asset->peripherals) {
                $peripheral = $asset->peripherals;
                $details['peripheral_type'] = $peripheral->peripheralsType->peripherals_type ?? 'N/A';
                $details['peripheral_specifications'] = $peripheral->specifications ?? 'N/A';
                $details['peripheral_manufacturer'] = $peripheral->manufacturer ?? 'N/A';
            }

            // Lifecycle details
            if ($asset->lifecycle) {
                $lifecycle = $asset->lifecycle;
                $details['acquisition_date'] = \Carbon\Carbon::parse($lifecycle->acquisition_date)->toDateString() ?? 'N/A';
                $details['retirement_date'] = \Carbon\Carbon::parse($lifecycle->retirement_date)->toDateString() ?? 'N/A';
                $details['lifecycle_status'] = $lifecycle->getLifecycleStatus() ?? 'N/A';
            }

            // Purchase details
            if ($asset->purchases && $asset->purchases->isNotEmpty()) {
                $purchase = $asset->purchases->first();
                $details['purchase_order_no'] = $purchase->purchase_order_no ?? 'N/A';
                $details['sales_invoice_no'] = $purchase->sales_invoice_no ?? 'N/A';
                $details['purchase_order_date'] = $purchase->purchase_order_date ?? 'N/A';
                $details['purchase_cost'] = $purchase->purchase_cost ?? 'N/A';
                $details['purchase_order_amount'] = $purchase->purchase_order_amount ?? 'N/A';
                $details['requestor'] = $purchase->requestor ?? 'N/A';

                // Vendor details
                if ($purchase->vendor) {
                    $vendor = $purchase->vendor;
                    $details['vendor_name'] = $vendor->name ?? 'N/A';
                    $details['vendor_address_1'] = $vendor->address_1 ?? 'N/A';
                    $details['vendor_address_2'] = $vendor->address_2 ?? 'N/A';
                    $details['vendor_city'] = $vendor->city ?? 'N/A';
                    $details['vendor_tel_no_1'] = $vendor->tel_no_1 ?? 'N/A';
                    $details['vendor_tel_no_2'] = $vendor->tel_no_2 ?? 'N/A';
                    $details['vendor_contact_person'] = $vendor->contact_person ?? 'N/A';
                    $details['vendor_mobile_number'] = $vendor->mobile_number ?? 'N/A';
                    $details['vendor_email'] = $vendor->email ?? 'N/A';
                    $details['vendor_url'] = $vendor->url ?? 'N/A';
                    $details['vendor_remarks'] = $vendor->remarks ?? 'N/A';
                } else {
                    Log::info('Asset ' . $asset->id . ' has no vendor information');
                }
            } else {
                Log::info('Asset ' . $asset->id . ' has no purchase information');
            }

        } catch (\Exception $e) {
            Log::error('Error getting asset details for asset ' . $asset->id . ': ' . $e->getMessage());
        }

        return $details;
    }

    private function getEmptyRow()
    {
        $columns = 45; // Total number of columns (removed software PC name and attached items)
        return array_fill(0, $columns, 'N/A');
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
