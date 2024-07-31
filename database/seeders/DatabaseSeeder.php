<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ensure vendors exist
        $vendors = [
            [
                'name' => 'PC Express',
                'address_1' => 'Unit 2, Ground Floor, PCX Building',
                'address_2' => 'No. 78 E. Rodriguez Sr. Avenue',
                'city' => 'Quezon City',
                'tel_no_1' => '+63 2 8953 0555',
                'tel_no_2' => '+63 2 8953 0666',
                'contact_person' => 'Maria Santos',
                'mobile_number' => '+63 917 123 4567',
                'email' => 'sales@pcexpress.com.ph',
                'url' => 'https://www.pcexpress.com.ph',
                'remarks' => 'Leading computer hardware retailer in the Philippines',
            ],
            [
                'name' => 'Complink',
                'address_1' => 'Complink Building, 99 A. Mabini Street',
                'address_2' => '',
                'city' => 'Manila',
                'tel_no_1' => '+63 2 8527 1654',
                'tel_no_2' => '+63 2 8527 1655',
                'contact_person' => 'John Doe',
                'mobile_number' => '+63 917 987 6543',
                'email' => 'info@complink.com.ph',
                'url' => 'https://www.complink.com.ph',
                'remarks' => 'Authorized reseller of major tech brands',
            ],
            [
                'name' => 'Abenson',
                'address_1' => 'Abenson Tower, 1238 Araneta Avenue',
                'address_2' => 'Barangay 21',
                'city' => 'Quezon City',
                'tel_no_1' => '+63 2 8925 6958',
                'tel_no_2' => '+63 2 8925 6968',
                'contact_person' => 'Luzviminda Cruz',
                'mobile_number' => '+63 917 654 3210',
                'email' => 'sales@abenson.com',
                'url' => 'https://www.abenson.com',
                'remarks' => 'Offers a wide range of electronics and appliances',
            ],
            [
                'name' => 'Systech',
                'address_1' => 'Unit 8, Building 7, IT Park',
                'address_2' => 'Cebu Business Park',
                'city' => 'Cebu City',
                'tel_no_1' => '+63 32 231 5432',
                'tel_no_2' => '+63 32 231 6543',
                'contact_person' => 'Ricardo Reyes',
                'mobile_number' => '+63 917 321 4321',
                'email' => 'support@systech.ph',
                'url' => 'https://www.systech.ph',
                'remarks' => 'Provides IT solutions and services',
            ],
            [
                'name' => 'Silicon Valley',
                'address_1' => 'Silicon Valley Building, 455 Ortigas Avenue',
                'address_2' => 'Pasig City',
                'city' => 'Metro Manila',
                'tel_no_1' => '+63 2 634 0567',
                'tel_no_2' => '+63 2 634 0987',
                'contact_person' => 'Ana Lopez',
                'mobile_number' => '+63 917 876 5432',
                'email' => 'info@siliconvalley.com.ph',
                'url' => 'https://www.siliconvalley.com.ph',
                'remarks' => 'Specializes in high-end computing solutions',
            ],
            [
                'name' => 'Dynaquest',
                'address_1' => 'Dynaquest Center, 123 EDSA',
                'address_2' => 'Mandaluyong City',
                'city' => 'Metro Manila',
                'tel_no_1' => '+63 2 726 1234',
                'tel_no_2' => '+63 2 726 5678',
                'contact_person' => 'Carlos Mendoza',
                'mobile_number' => '+63 917 543 2109',
                'email' => 'contact@dynaquest.com.ph',
                'url' => 'https://www.dynaquest.com.ph',
                'remarks' => 'Known for its enterprise solutions and IT support',
            ],
        ];

        foreach ($vendors as $vendor) {
            DB::table('vendors')->updateOrInsert(
                ['name' => $vendor['name']], // Unique key based on the vendor name
                $vendor
            );
        }


        // Define the brands, models, and specifications
        $assets = [
            // **Hardware**:
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Apple',
                'model' => 'MacBook Pro (16-inch, 2023)',
                'remarks' => 'High-end model for professionals.',
                'specifications' => '16-inch Liquid Retina XDR display, Apple M2 Max, 64GB RAM, 2TB SSD'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Dell',
                'model' => 'Alienware x17',
                'remarks' => 'Gaming laptop with high performance.',
                'specifications' => '17.3-inch FHD display, Intel Core i9-11900HK, NVIDIA GeForce RTX 3080, 32GB RAM'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'HP',
                'model' => 'Spectre x360 14',
                'remarks' => 'Convertible laptop with excellent build quality.',
                'specifications' => '13.5-inch OLED display, Intel Core i7-1165G7, 16GB RAM, 1TB SSD'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Asus',
                'model' => 'ROG Zephyrus G14',
                'remarks' => 'Powerful gaming laptop with compact design.',
                'specifications' => '14-inch QHD display, AMD Ryzen 9 5900HS, NVIDIA GeForce RTX 3060, 32GB RAM'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Acer',
                'model' => 'Nitro V',
                'remarks' => 'Gaming laptop with high-end features.',
                'specifications' => '15.6-inch FHD display, Intel i5 13th Gen, NVIDIA RTX 4050, 1TB SSD, 16GB RAM'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Microsoft',
                'model' => 'Surface Laptop 5',
                'remarks' => 'Premium laptop with great display and performance.',
                'specifications' => '13.5-inch PixelSense display, Intel Core i7-1265U, 16GB RAM, 512GB SSD'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Sony',
                'model' => 'PlayStation 5',
                'remarks' => 'Latest gaming console with powerful specs.',
                'specifications' => '8-core AMD Zen 2 CPU, AMD RDNA 2 GPU, 825GB SSD, 16GB GDDR6 RAM'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Intel',
                'model' => 'Xeon W-3375',
                'remarks' => 'High-performance workstation CPU.',
                'specifications' => '38 cores, 76 threads, 4.0 GHz base clock'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'AMD',
                'model' => 'Radeon RX 7900 XT',
                'remarks' => 'High-end graphics card for gaming and professional work.',
                'specifications' => '24GB GDDR6 memory, 5376 stream processors, Ray tracing'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Huawei',
                'model' => 'MateBook X Pro',
                'remarks' => 'Premium ultrabook with high-resolution display.',
                'specifications' => '13.9-inch 3K display, Intel Core i7-1165G7, 16GB RAM, 1TB SSD'
            ],
            [
                'asset_type' => 'hardware',
                'asset_status' => rand(1, 7),
                'brand' => 'Xiaomi',
                'model' => 'Mi 11 Ultra',
                'remarks' => 'Flagship smartphone with top-notch specs.',
                'specifications' => '6.81-inch AMOLED display, Snapdragon 888, 50MP triple-camera system'
            ],

            // **Software**:
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Adobe',
                'model' => 'Photoshop CC',
                'remarks' => 'Industry-standard photo editing software.',
                'specifications' => 'Version CC 2024, support for AI-based tools, advanced image manipulation features'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Adobe',
                'model' => 'Illustrator CC',
                'remarks' => 'Vector graphics editor with comprehensive design tools.',
                'specifications' => 'Version CC 2024, advanced vector graphics creation and editing'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'VMware',
                'model' => 'vSphere 8',
                'remarks' => 'Latest version of VMware’s hypervisor platform.',
                'specifications' => 'Enhanced scalability, support for the latest hardware, advanced security features'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'VMware',
                'model' => 'NSX-T 3.2',
                'remarks' => 'Network virtualization platform with advanced features.',
                'specifications' => 'Enhanced networking and security features, multi-cloud support'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Salesforce',
                'model' => 'Sales Cloud',
                'remarks' => 'Comprehensive CRM platform.',
                'specifications' => 'Sales automation, lead management, and reporting features'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Salesforce',
                'model' => 'Marketing Cloud',
                'remarks' => 'Integrated marketing platform with various tools.',
                'specifications' => 'Email marketing, social media management, and customer journey analytics'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Palantir Technologies',
                'model' => 'Foundry',
                'remarks' => 'Data integration and analytics platform.',
                'specifications' => 'Advanced data integration, analysis, and visualization tools'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Palantir Technologies',
                'model' => 'Gotham',
                'remarks' => 'Analytical platform for data integration and intelligence.',
                'specifications' => 'Data integration, analysis, and operational tools for enterprises'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Qualys',
                'model' => 'Vulnerability Management',
                'remarks' => 'Automated vulnerability scanning and management.',
                'specifications' => 'Comprehensive vulnerability scanning, risk assessment, and management features'
            ],
            [
                'asset_type' => 'software',
                'asset_status' => rand(1, 7),
                'brand' => 'Elastic',
                'model' => 'Elasticsearch',
                'remarks' => 'Search and analytics engine.',
                'specifications' => 'Full-text search capabilities, distributed search architecture, real-time indexing'
            ],

            // **Peripherals**:
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Apple',
                'model' => 'AirPods Pro (2nd generation)',
                'remarks' => 'High-quality wireless earbuds.',
                'specifications' => 'Active Noise Cancellation, Transparency mode, Adaptive EQ'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Samsung',
                'model' => 'Galaxy Buds 2 Pro',
                'remarks' => 'Premium wireless earbuds with advanced features.',
                'specifications' => 'High-fidelity audio, Active Noise Cancellation, IPX7 water resistance'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Dell',
                'model' => 'UltraSharp U2720Q Monitor',
                'remarks' => 'High-resolution 4K monitor.',
                'specifications' => '27-inch 4K UHD display, USB-C connectivity, HDR400 support'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'HP',
                'model' => 'HP Reverb G2',
                'remarks' => 'High-resolution VR headset.',
                'specifications' => '2160 x 2160 resolution per eye, Inside-out tracking, SteamVR compatibility'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Logitech',
                'model' => 'MX Master 3S Mouse',
                'remarks' => 'Advanced ergonomic mouse.',
                'specifications' => 'Darkfield high precision sensor, 70 days battery life, customizable buttons'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Asus',
                'model' => 'ROG Strix Scar 15 Keyboard',
                'remarks' => 'High-performance gaming keyboard.',
                'specifications' => 'RGB backlighting, programmable keys, mechanical switches'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Corsair',
                'model' => 'HS70 Pro Wireless Headset',
                'remarks' => 'Wireless gaming headset.',
                'specifications' => '7.1 surround sound, wireless connectivity, 16-hour battery life'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Razer',
                'model' => 'DeathAdder V2 Mouse',
                'remarks' => 'High-precision gaming mouse.',
                'specifications' => 'Focus+ Optical Sensor, Speedflex cable, Razer Optical Mouse Switches'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'Wacom',
                'model' => 'Intuos Pro Tablet',
                'remarks' => 'Professional drawing tablet.',
                'specifications' => '8192 levels of pressure sensitivity, multi-touch surface, wireless connectivity'
            ],
            [
                'asset_type' => 'peripherals',
                'asset_status' => rand(1, 7),
                'brand' => 'BenQ',
                'model' => 'EL2870U Monitor',
                'remarks' => '4K monitor for various uses.',
                'specifications' => '28-inch 4K UHD display, HDR10 support, 1ms response time'
            ],
        ];

        DB::beginTransaction();

        try {
            foreach ($assets as $asset) {
                Log::info("Processing asset: Brand: {$asset['brand']}, Model: {$asset['model']}");

                $assetStatus = rand(1, 7);

                // Retrieve valid vendor IDs
                $validVendorIds = DB::table('vendors')->pluck('id')->toArray();
                Log::info("Valid vendor IDs retrieved: " . implode(', ', $validVendorIds));

                // Insert or update the asset
                DB::table('assets')->updateOrInsert(
                    [
                        'brand' => $asset['brand'],
                        'model' => $asset['model'],
                    ],
                    [
                        'asset_type' => $asset['asset_type'],
                        'asset_status' => $assetStatus,
                        'remarks' => $asset['specifications'],
                    ]
                );

                // Retrieve the asset_id
                $assetId = DB::table('assets')
                    ->where('brand', $asset['brand'])
                    ->where('model', $asset['model'])
                    ->value('id');

                if ($assetId) {
                    Log::info("Asset ID {$assetId} retrieved successfully");

                    // Insert into hardware table
                    if ($asset['asset_type'] == 'hardware') {
                        Log::info("Inserting/updating hardware data for Asset ID {$assetId}");
                        DB::table('hardware')->updateOrInsert(
                            ['asset_id' => $assetId],
                            [
                                'hardware_type' => 1, // Adjust according to your hardware types
                                'specifications' => $asset['specifications'],
                                'serial_number' => str_pad($assetId, 6, '0', STR_PAD_LEFT),
                                'manufacturer' => $asset['brand'],
                                'warranty_expiration' => now()->addYears(2)->format('Y-m-d'),
                            ]
                        );
                        Log::info("Hardware data for Asset ID {$assetId} inserted/updated successfully");
                    }

                    // Insert into software table
                    if ($asset['asset_type'] == 'software') {
                        Log::info("Inserting/updating software data for Asset ID {$assetId}");
                        DB::table('software')->updateOrInsert(
                            ['asset_id' => $assetId],
                            [
                                'software_type' => rand(1, 11), // Adjust according to your software types
                                'version' => 'v' . rand(1, 30),
                                'license_type' => rand(1, 7), // Adjust according to your license types
                                'license_key' => strtoupper(bin2hex(random_bytes(16))),
                            ]
                        );
                        Log::info("Software data for Asset ID {$assetId} inserted/updated successfully");
                    }

                    // Insert into peripherals table
                    if ($asset['asset_type'] == 'peripherals') {
                        Log::info("Inserting/updating peripherals data for Asset ID {$assetId}");
                        DB::table('peripherals')->updateOrInsert(
                            ['asset_id' => $assetId],
                            [
                                'peripherals_type' => rand(1,3),
                                'specifications' => $asset['specifications'],
                                'serial_number' => str_pad($assetId, 6, '0', STR_PAD_LEFT),
                                'manufacturer' => $asset['brand'],
                                'warranty_expiration' => now()->addYears(1)->format('Y-m-d'),
                            ]
                        );
                        Log::info("Peripherals data for Asset ID {$assetId} inserted/updated successfully");
                    }

                    // Insert into lifecycles table
                    Log::info("Inserting/updating lifecycle data for Asset ID {$assetId}");
                    DB::table('lifecycles')->updateOrInsert(
                        ['asset_id' => $assetId],
                        [
                            'acquisition_date' => now()->format('Y-m-d'),
                            'retirement_date' => now()->addYears(5)->format('Y-m-d'),
                        ]
                    );
                    Log::info("Lifecycle data for Asset ID {$assetId} inserted/updated successfully");

                    // Insert into purchases table
                    Log::info("Inserting/updating purchase data for Asset ID {$assetId}");
                    DB::table('purchases')->updateOrInsert(
                        ['asset_id' => $assetId],
                        [
                            'purchase_order_no' => str_pad($assetId, 6, '0', STR_PAD_LEFT),
                            'sales_invoice_no' => str_pad($assetId, 6, '0', STR_PAD_LEFT),
                            'purchase_order_date' => now()->format('Y-m-d'),
                            'purchase_order_amount' => rand(5000, 200000),
                            'vendor_id' => $validVendorIds[array_rand($validVendorIds)],
                        ]
                    );
                    Log::info("Purchase data for Asset ID {$assetId} inserted/updated successfully");

                    Log::info("Data updated for asset ID {$assetId}");
                } else {
                    Log::error("Failed to retrieve asset ID for Brand: {$asset['brand']}, Model: {$asset['model']}");
                }
            }

            DB::commit();
            Log::info("Transaction committed successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Transaction failed: " . $e->getMessage());
        }
    }
}
