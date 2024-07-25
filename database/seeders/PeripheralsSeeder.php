<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeripheralsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define data to be inserted
        $peripherals = [
            [
                'asset_id' => 7,
                'specifications' => 'Keyboard with backlighting',
                'serial_number' => 'KB12345',
                'manufacturer' => 'Logitech',
                'warranty_expiration' => '2025-06-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 10,
                'specifications' => 'Wireless mouse',
                'serial_number' => 'MS7890',
                'manufacturer' => 'Microsoft',
                'warranty_expiration' => '2024-12-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more peripherals as needed
        ];

        // Insert data into the peripherals table
        DB::table('peripherals')->insert($peripherals);
    }
}
