<?php

namespace App\Exports;

use App\Models\Asset;
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
            $assets = Asset::with([
                'model.brand',
                'costCode',
                'assetStatus',
                'hardware.hardwareType',
                'hardware.pcName',
                'software.softwareType',
                'software.licenseType',
                'peripherals.peripheralsType',
                'lifecycle',
                'purchases.vendor',
                'assignments.employee',
                'assignments.status'
            ])->get();

            // Create separate rows for each assignment
            $rows = collect();

            foreach ($assets as $asset) {
                if ($asset->assignments->isEmpty()) {
                    // Asset with no assignments - create one row with empty assignment data
                    $rows->push((object) [
                        'asset' => $asset,
                        'assignment' => null
                    ]);
                } else {
                    // Asset with assignments - create one row per assignment
                    foreach ($asset->assignments as $assignment) {
                        $rows->push((object) [
                            'asset' => $asset,
                            'assignment' => $assignment
                        ]);
                    }
                }
            }

            return $rows;
        } catch (\Exception $e) {
            Log::error('Error in AssetReportExport collection: ' . $e->getMessage());
            return collect([]);
        }
    }

    public function headings(): array
    {
        return [
            // Asset Basic Information
            'Asset ID',
            'Tag Number',
            'Asset Type',
            'Asset Name',
            'Brand',
            'Model',
            'Asset Status',
            'Cost Code',

            // Hardware Details
            'Hardware Type',
            'Hardware Serial Number',
            'Hardware Specifications',
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
            'Vendor Remarks',

            // Assignment Information (single assignment per row)
            'Assigned Employee ID',
            'Assigned Employee Name',
            'Assignment Status',
            'Assignment Start Date',
            'Assignment End Date'
        ];
    }

    public function map($row): array
    {
        try {
            $asset = $row->asset;
            $assignment = $row->assignment;

            // Get asset details (reuse existing logic)
            $assetDetails = $this->getAssetDetails($asset);

            // Get assignment data for this specific assignment
            $assignmentData = $this->getAssignmentData($assignment);

            return array_merge([
                // Asset Basic Information
                $asset->id,
                $asset->tag_number ?? 'N/A',
                $asset->asset_type ?? 'N/A',
                $assetDetails['name'] ?? 'N/A',
                $assetDetails['brand'] ?? 'N/A',
                $assetDetails['model'] ?? 'N/A',
                $asset->assetStatus ? $asset->assetStatus->asset_status : 'N/A',
                $asset && $asset->costCode ? $asset->costCode->name : 'N/A',

                // Hardware Details
                $assetDetails['hardware_type'] ?? 'N/A',
                $assetDetails['hardware_serial_number'] ?? 'N/A',
                $assetDetails['hardware_specifications'] ?? 'N/A',
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
                $assetDetails['vendor_remarks'] ?? 'N/A',
            ], $assignmentData);

        } catch (\Exception $e) {
            Log::error('Error mapping row: ' . $e->getMessage());
            return $this->getEmptyRow();
        }
    }

    private function getAssignmentData($assignment): array
    {
        if (!$assignment || !$assignment->employee) {
            // No assignment - return empty values
            return ['', '', '', '', ''];
        }

        return [
            $assignment->employee->id_num ?? '',
            $assignment->employee->full_name ?? '',
            $assignment->status ? $assignment->status->assignment_status : '',
            $assignment->start_date ? \Carbon\Carbon::parse($assignment->start_date)->toDateString() : '',
            $assignment->end_date ?? '',
        ];
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

                    // For software, only show brand (model name = brand name)
                    if ($asset->asset_type === 'software') {
                        $details['name'] = $asset->model->brand->name ?? '';
                        $details['model'] = 'N/A'; // Don't show model for software
                    } else {
                        // For hardware/peripherals, show brand + model
                        $details['name'] = ($asset->model->brand->name ?? '') . ' ' . ($asset->model->name ?? '');
                    }
                }
            }

            // Hardware details
            if ($asset->hardware) {
                $hardware = $asset->hardware;
                $details['hardware_type'] = $hardware->hardwareType ? $hardware->hardwareType->hardware_type : 'N/A';
                $details['hardware_serial_number'] = $hardware->serial_number ?? 'N/A';
                $details['hardware_specifications'] = $hardware->specifications ?? 'N/A';
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
        $totalColumns = 51; // Fixed number of columns (46 asset columns + 5 assignment columns)
        return array_fill(0, $totalColumns, 'N/A');
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
