<?php

namespace App\Filament\Resources\AssetResource\Actions;

use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Peripheral;
use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Lifecycle;
use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\CostCode;
use App\Models\AssetStatus;
use App\Models\HardwareType;
use App\Models\SoftwareType;
use App\Models\LicenseType;
use App\Models\PeripheralType;
use App\Models\PCName;
use App\Models\Division;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

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
                    ->label('CSV/Excel File')
                    ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->disk('public')
                    ->directory('imports')
                    ->required(),
            ])
            ->extraModalFooterActions([
                Action::make('download_example')
                    ->label('Download Example Excel')
                    ->color('secondary')
                    ->action(function () {
                        return response()->streamDownload(function () {
                            echo $this->generateExampleExcel();
                        }, 'example_assets_import.xlsx');
                    }),
            ]);
    }

    protected function generateExampleExcel(): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define column headers
        $headers = [
            'asset_type',
            'asset_status',
            'brand',
            'model',
            'cost_code',
            'project',
            'division',
            'tag_number',
            'acquisition_date',
            'retirement_date',
            'purchase_order_no',
            'sales_invoice_no',
            'purchase_order_amount',
            'requestor',
            // Hardware specific
            'hardware_type',
            'serial_number',
            'specifications',
            'mac_address',
            'accessories',
            'pc_name',
            // Software specific
            'version',
            'license_key',
            'software_type',
            'license_type',
            // Peripheral specific
            'peripherals_type',
            // Vendor information
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
        ];

        // Define which columns are required for each asset type
        $requiredColumns = [
            // asset_type, asset_status, brand, model, cost_code,
            // acquisition_date, purchase_order_no, sales_invoice_no, purchase_order_amount, vendor_name
            'common' => [0, 1, 2, 3, 4, 8, 10, 11, 12, 25],
            // tag_number, hardware_type, serial_number, specifications
            'hardware' => [7, 14, 15, 16],
            // version, license_key, software_type, license_type
            'software' => [20, 21, 22, 23],
            // peripherals_type, serial_number, specifications
            'peripherals' => [24, 15, 16],
        ];

        // Set headers
        foreach ($headers as $col => $header) {
            $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . '1', $header);
        }

        // Add example data
        $exampleData = [
            // Hardware example
            [
                'hardware', 'Active', 'Dell', 'Optiplex 7010', 'CC001', 'Project A', 'Division 1', 'FB-HW-001',
                '2023-01-01', '2028-01-01', 'PO123', 'INV456', '1500.00', 'John Doe',
                'Desktop', 'SN12345', 'Intel Core i7, 16GB RAM, 512GB SSD',
                '00:11:22:33:44:55', 'Mouse, Keyboard', 'DESKTOP-ABC123',
                '', '', '', '',
                'Dell Inc.', '123 Dell Way', '', 'Round Rock', '1234567890', '',
                'Jane Smith', '9876543210', 'jane@dell.com', 'www.dell.com', 'Preferred vendor'
            ],
            // Software example
            [
                'software', 'Active', 'Microsoft', 'Office 365', 'CC002', 'Project B', 'Division 2', '',
                '2023-02-01', '2024-02-01', 'PO789', 'INV101', '300.00', 'Jane Smith',
                '', '', '', '', '','DESKTOP-ABC123',
                '2021', 'XXXX-XXXX-XXXX-XXXX', 'Application', 'Subscription',
                '', 'Microsoft Corporation', 'One Microsoft Way', '', 'Redmond', '4258828080', '',
                'John Doe', '5551234567', 'support@microsoft.com', 'www.microsoft.com', 'Software vendor'
            ],
            // Peripheral example
            [
                'peripherals', 'Active', 'Logitech', 'Wireless Mouse', 'CC003', 'Project C', 'Division 3', '',
                '2023-03-01', '2026-03-01', 'PO202', 'INV303', '100.00', 'Bob Johnson',
                '', 'LGT123456', 'Wireless Mouse', '', '', '',
                '', '', '', '',
                'Monitor', 'Logitech Inc.', '7700 Gateway Blvd', '', 'Newark', '5105795000', '',
                'Sarah Brown', '9876543210', 'sarah@logitech.com', 'www.logitech.com', 'Peripheral supplier'
            ]
        ];

        // Add data rows
        foreach ($exampleData as $rowIndex => $rowData) {
            $row = $rowIndex + 2; // Start from row 2 (after headers)
            foreach ($rowData as $col => $value) {
                $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . $row, $value);
            }
        }

        // Apply red background to required columns for each asset type
        $this->applyRequiredColumnColors($sheet, $requiredColumns, count($exampleData) + 1);

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Generate Excel file
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'example_assets_import');
        $writer->save($tempFile);

        $content = file_get_contents($tempFile);
        unlink($tempFile);

        return $content;
    }

    protected function applyRequiredColumnColors($sheet, $requiredColumns, $maxRow)
    {
        $redFill = [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFCCCC'] // Light red background
        ];

        // Apply colors to common required columns
        foreach ($requiredColumns['common'] as $col) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->getStyle($columnLetter . '1:' . $columnLetter . $maxRow)->getFill()->applyFromArray($redFill);
        }

        // Apply colors to hardware-specific required columns (row 2)
        foreach ($requiredColumns['hardware'] as $col) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->getStyle($columnLetter . '2')->getFill()->applyFromArray($redFill);
        }

        // Apply colors to software-specific required columns (row 3)
        foreach ($requiredColumns['software'] as $col) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->getStyle($columnLetter . '3')->getFill()->applyFromArray($redFill);
        }

        // Apply colors to peripheral-specific required columns (row 4)
        foreach ($requiredColumns['peripherals'] as $col) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->getStyle($columnLetter . '4')->getFill()->applyFromArray($redFill);
        }
    }

    protected function process($file): void
    {
        Log::info('Starting asset import process', ['file' => $file]);

        // Get the path to the uploaded file
        $path = Storage::disk('public')->path($file);

        // Check if file exists, if not try local disk
        if (!file_exists($path)) {
            $path = Storage::disk('local')->path($file);
        }

        // If still not found, try the file directly
        if (!file_exists($path)) {
            $path = $file;
        }

        // Final check if file exists
        if (!file_exists($path)) {
            Log::error('File not found', [
                'original_file' => $file,
                'tried_paths' => [
                    Storage::disk('public')->path($file),
                    Storage::disk('local')->path($file),
                    $file
                ]
            ]);
            throw new \Exception("File not found: {$file}");
        }

        Log::info('File found at path', ['path' => $path]);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $records = [];

        if (strtolower($extension) === 'xlsx' || strtolower($extension) === 'xls') {
            // Handle Excel files
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);
            $worksheet = $spreadsheet->getActiveSheet();

            // Get all data as array
            $dataArray = $worksheet->toArray();
            if (empty($dataArray)) {
                throw new \Exception('Excel file appears to be empty');
            }

            // First row should be headers
            $headers = array_shift($dataArray);

            // Convert remaining rows to associative arrays
            foreach ($dataArray as $rowData) {
                $combined = array_combine($headers, $rowData);
                $records[] = $combined;
            }
        } else {
            // Handle CSV files
            $csv = Reader::createFromPath($path, 'r');
            $csv->setHeaderOffset(0);
            $headers = $csv->getHeader();
            $records = $csv->getRecords();
        }
        $processedRows = 0;
        $successfulRows = 0;
        $failedRows = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($records as $index => $record) {
                $processedRows++;
                $rowNumber = $index + 2; // +2 because header is row 1 and array is 0-indexed

                Log::info("Processing row {$rowNumber}", ['data' => $record]);

                try {
                    $this->createSingleAsset($record, $rowNumber);
                    $successfulRows++;
                    Log::info("Successfully processed row {$rowNumber}");
                } catch (\Exception $e) {
                    $failedRows++;
                    $errorMessage = "Row {$rowNumber}: " . $e->getMessage();
                    $errors[] = $errorMessage;
                    Log::error("Failed to process row {$rowNumber}", [
                        'error' => $e->getMessage(),
                        'data' => $record
                    ]);
                }
            }

            if ($failedRows > 0) {
                DB::rollBack();

                $errorDetails = implode("\n", $errors);
                Log::error('Import failed due to validation errors', [
                    'total_rows' => $processedRows,
                    'successful_rows' => $successfulRows,
                    'failed_rows' => $failedRows,
                    'errors' => $errors
                ]);

                Notification::make()
                    ->title('Import failed')
                    ->body("Failed to import {$failedRows} out of {$processedRows} rows.\n\nErrors:\n{$errorDetails}")
                    ->danger()
                    ->persistent()
                    ->send();
            } else {
                DB::commit();

                Log::info('Import completed successfully', [
                    'total_rows' => $processedRows,
                    'successful_rows' => $successfulRows
                ]);

                Notification::make()
                    ->title('Assets imported successfully')
                    ->body("Successfully imported {$successfulRows} assets")
                    ->success()
                    ->send();
            }
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Import process failed with exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Notification::make()
                ->title('Import failed')
                ->body('An unexpected error occurred: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function createSingleAsset(array $data, int $rowNumber): Asset
    {
        // Validate common asset data
        $this->validateCommonData($data, $rowNumber);

        // Normalize and get IDs for referenced data
        $modelId = $this->normalizeModel($data, $rowNumber);
        $costContext = $this->normalizeCostCode($data, $rowNumber);
        $vendorId = $this->normalizeVendor($data, $rowNumber);
        $assetStatusId = $this->normalizeAssetStatus($data, $rowNumber);

        // Create the main asset record
        $assetData = [
            'asset_type' => $data['asset_type'],
            'asset_status' => $assetStatusId,
            'model_id' => $modelId,
            'cost_code' => $costContext['cost_code_id'],
        ];

        // Only add tag_number for hardware assets
        if ($data['asset_type'] === 'hardware' && !empty($data['tag_number'])) {
            $assetData['tag_number'] = $data['tag_number'];
        }

        // Attach optional project/division if available
        if (isset($costContext['project_id'])) {
            $assetData['project_id'] = $costContext['project_id'];
        }
        if (isset($costContext['division_id'])) {
            $assetData['division_id'] = $costContext['division_id'];
        }

        $asset = Asset::create($assetData);

        Log::info("Created asset with ID: {$asset->id}", ['asset_type' => $data['asset_type']]);

        // Create lifecycle record
        Lifecycle::create([
            'asset_id' => $asset->id,
            'acquisition_date' => $data['acquisition_date'],
            'retirement_date' => $data['retirement_date'] ?? null,
        ]);

        // Create purchase record
        Purchase::create([
            'asset_id' => $asset->id,
            'purchase_order_no' => $data['purchase_order_no'],
            'sales_invoice_no' => $data['sales_invoice_no'],
            'purchase_order_date' => $data['acquisition_date'], // Use acquisition_date for purchase_order_date
            'purchase_order_amount' => $data['purchase_order_amount'],
            'vendor_id' => $vendorId,
            'requestor' => $data['requestor'] ?? null,
        ]);

        // Create type-specific record
        switch ($data['asset_type']) {
            case 'hardware':
                $this->createHardware($asset, $data, $rowNumber);
                break;
            case 'software':
                $this->createSoftware($asset, $data, $rowNumber);
                break;
            case 'peripherals':
                $this->createPeripheral($asset, $data, $rowNumber);
                break;
        }

        return $asset;
    }

    protected function validateCommonData(array $data, int $rowNumber): void
    {
        $validator = Validator::make($data, [
            'asset_type' => 'required|in:hardware,software,peripherals',
            'asset_status' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'cost_code' => 'required|string|max:255',
            'project' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'acquisition_date' => 'required|date',
            'retirement_date' => 'nullable|date|after:acquisition_date',
            'purchase_order_no' => 'required|string|max:255',
            'sales_invoice_no' => 'required|string|max:255',
            'purchase_order_amount' => 'required|numeric|min:0',
            'requestor' => 'nullable|string|max:255',
            'vendor_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . $validator->errors()->first());
        }
    }

    protected function normalizeModel(array $data, int $rowNumber): int
    {
        $brandName = trim($data['brand']);
        $modelName = trim($data['model']);

        // Find or create brand
        $brand = Brand::firstOrCreate(
            ['name' => $brandName],
            ['name' => $brandName]
        );

        Log::info("Normalized brand: {$brandName} (ID: {$brand->id})");

        // Find or create model
        $model = ProductModel::firstOrCreate(
            [
                'brand_id' => $brand->id,
                'name' => $modelName
            ],
            [
                'brand_id' => $brand->id,
                'name' => $modelName,
                'description' => "{$brandName} {$modelName}"
            ]
        );

        Log::info("Normalized model: {$modelName} (ID: {$model->id})");

        return $model->id;
    }

    protected function normalizeCostCode(array $data, int $rowNumber): array
    {
        $costCodeName = trim($data['cost_code']);
        $projectName = isset($data['project']) ? trim((string) $data['project']) : '';
        $divisionName = isset($data['division']) ? trim((string) $data['division']) : '';

        // If cost code exists by name anywhere, use it directly
        $existingCostCode = CostCode::where('name', $costCodeName)->first();
        if ($existingCostCode) {
            Log::info('Found existing cost code', [
                'cost_code' => $existingCostCode->name,
                'project_id' => $existingCostCode->project_id,
            ]);
            return [
                'cost_code_id' => $existingCostCode->id,
                'project_id' => $existingCostCode->project_id,
                'division_id' => optional($existingCostCode->project)->division_id ?? null,
            ];
        }

        // Cost code not found: we need at least a project, otherwise a division to create a project
        if ($projectName === '') {
            if ($divisionName === '') {
                throw new \Exception("Cost code '{$costCodeName}' not found. Please provide project and/or division to create it.");
            }
            // Ensure division exists
            $division = Division::firstOrCreate(
                ['name' => $divisionName],
                ['name' => $divisionName]
            );
            // Create a default project under division if project not provided
            $projectName = 'General';
            $project = Project::firstOrCreate(
                ['name' => $projectName, 'division_id' => $division->id],
                ['name' => $projectName, 'division_id' => $division->id]
            );
        } else {
            // Try to find project by name, optionally within division if given
            $projectQuery = Project::query()->where('name', $projectName);
            if ($divisionName !== '') {
                $division = Division::firstOrCreate(
                    ['name' => $divisionName],
                    ['name' => $divisionName]
                );
                $projectQuery->where('division_id', $division->id);
            }
            $project = $projectQuery->first();
            if (!$project) {
                // Create division if necessary
                if (!isset($division)) {
                    $division = Division::firstOrCreate(
                        ['name' => $divisionName !== '' ? $divisionName : 'General'],
                        ['name' => $divisionName !== '' ? $divisionName : 'General']
                    );
                }
                $project = Project::create([
                    'name' => $projectName,
                    'division_id' => $division->id,
                ]);
            }
        }

        // Create cost code under project
        $costCode = CostCode::firstOrCreate(
            ['name' => $costCodeName, 'project_id' => $project->id],
            ['name' => $costCodeName, 'project_id' => $project->id, 'active' => true]
        );

        Log::info('Normalized cost code', [
            'cost_code' => $costCode->name,
            'project' => $project->name,
            'division' => $division->name,
        ]);

        // Return context for saving
        return [
            'cost_code_id' => $costCode->id,
            'project_id' => $project->id,
            'division_id' => $division->id,
        ];
    }

    protected function normalizeAssetStatus(array $data, int $rowNumber): int
    {
        $assetStatusName = trim($data['asset_status']);

        // Find asset status by name (case insensitive)
        $assetStatus = AssetStatus::whereRaw('LOWER(asset_status) = ?', [strtolower($assetStatusName)])->first();

        if (!$assetStatus) {
            throw new \Exception("Asset status '{$assetStatusName}' not found. Valid statuses are: Active, Inactive, Under Repair, In Transfer, Disposed, Lost, Stolen");
        }

        Log::info("Normalized asset status: {$assetStatusName} (ID: {$assetStatus->id})");

        return $assetStatus->id;
    }

    protected function normalizeVendor(array $data, int $rowNumber): int
    {
        $vendorName = trim($data['vendor_name']);

        // Check if vendor exists by name
        $vendor = Vendor::where('name', $vendorName)->first();

        if ($vendor) {
            Log::info("Found existing vendor: {$vendorName} (ID: {$vendor->id})");
            return $vendor->id;
        }

        // Create new vendor with provided data
        $vendorData = [
            'name' => $vendorName,
            'address_1' => !empty($data['vendor_address_1']) ? $data['vendor_address_1'] : '',
            'address_2' => !empty($data['vendor_address_2']) ? $data['vendor_address_2'] : '',
            'city' => !empty($data['vendor_city']) ? $data['vendor_city'] : '',
            'tel_no_1' => !empty($data['vendor_tel_no_1']) ? $data['vendor_tel_no_1'] : '',
            'tel_no_2' => !empty($data['vendor_tel_no_2']) ? $data['vendor_tel_no_2'] : '',
            'contact_person' => !empty($data['vendor_contact_person']) ? $data['vendor_contact_person'] : '',
            'mobile_number' => !empty($data['vendor_mobile_number']) ? $data['vendor_mobile_number'] : '',
            'email' => !empty($data['vendor_email']) ? $data['vendor_email'] : '',
            'url' => !empty($data['vendor_url']) ? $data['vendor_url'] : '',
            'remarks' => !empty($data['vendor_remarks']) ? $data['vendor_remarks'] : '',
        ];

        $vendor = Vendor::create($vendorData);

        Log::info("Created new vendor: {$vendorName} (ID: {$vendor->id})");

        return $vendor->id;
    }

    protected function createHardware(Asset $asset, array $data, int $rowNumber): void
    {
        $validator = Validator::make($data, [
            'tag_number' => 'required|string|max:255',
            'hardware_type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'specifications' => 'required|string',
            'mac_address' => 'nullable|string|max:255',
            'accessories' => 'nullable|string|max:255',
            'pc_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Hardware validation failed: ' . $validator->errors()->first());
        }

        // Normalize hardware type
        $hardwareType = HardwareType::firstOrCreate(
            ['hardware_type' => trim($data['hardware_type'])],
            ['hardware_type' => trim($data['hardware_type'])]
        );

        // Normalize PC name if provided
        $pcNameId = null;
        if (!empty($data['pc_name'])) {
            $pcName = PCName::firstOrCreate(
                ['name' => trim($data['pc_name'])],
                [
                    'name' => trim($data['pc_name']),
                    'description' => "PC Name: " . trim($data['pc_name'])
                ]
            );
            $pcNameId = $pcName->id;
        }

        Hardware::create([
            'asset_id' => $asset->id,
            'hardware_type' => $hardwareType->id,
            'serial_number' => $data['serial_number'],
            'specifications' => $data['specifications'],
            'warranty_expiration' => $data['retirement_date'] ?? null, // Use retirement_date for warranty_expiration
            'mac_address' => $data['mac_address'] ?? null,
            'accessories' => $data['accessories'] ?? null,
            'pc_name_id' => $pcNameId,
        ]);

        Log::info("Created hardware record for asset ID: {$asset->id}");
    }

    protected function createSoftware(Asset $asset, array $data, int $rowNumber): void
    {
        $validator = Validator::make($data, [
            'version' => 'required|string|max:255',
            'license_key' => 'required|string|max:255',
            'software_type' => 'required|string|max:255',
            'license_type' => 'required|string|max:255',
            'pc_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Software validation failed: ' . $validator->errors()->first());
        }

        // Normalize software type
        $softwareType = SoftwareType::firstOrCreate(
            ['software_type' => trim($data['software_type'])],
            ['software_type' => trim($data['software_type'])]
        );

        // Normalize license type
        $licenseType = LicenseType::firstOrCreate(
            ['license_type' => trim($data['license_type'])],
            ['license_type' => trim($data['license_type'])]
        );

        // Normalize PC name if provided
        $pcNameId = null;
        if (!empty($data['pc_name'])) {
            $pcName = PCName::firstOrCreate(
                ['name' => trim($data['pc_name'])],
                [
                    'name' => trim($data['pc_name']),
                    'description' => "PC Name: " . trim($data['pc_name'])
                ]
            );
            $pcNameId = $pcName->id;
        }

        Software::create([
            'asset_id' => $asset->id,
            'version' => $data['version'],
            'license_key' => $data['license_key'],
            'software_type' => $softwareType->id,
            'license_type' => $licenseType->id,
            'pc_name_id' => $pcNameId,
        ]);

        Log::info("Created software record for asset ID: {$asset->id}");
    }

    protected function createPeripheral(Asset $asset, array $data, int $rowNumber): void
    {
        $validator = Validator::make($data, [
            'peripherals_type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'specifications' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Peripheral validation failed: ' . $validator->errors()->first());
        }

        // Normalize peripheral type
        $peripheralType = PeripheralType::firstOrCreate(
            ['peripherals_type' => trim($data['peripherals_type'])],
            ['peripherals_type' => trim($data['peripherals_type'])]
        );

        Peripheral::create([
            'asset_id' => $asset->id,
            'peripherals_type' => $peripheralType->id,
            'serial_number' => $data['serial_number'],
            'specifications' => $data['specifications'],
            'warranty_expiration' => $data['retirement_date'] ?? null, // Use retirement_date for warranty_expiration
        ]);

        Log::info("Created peripheral record for asset ID: {$asset->id}");
    }
}
