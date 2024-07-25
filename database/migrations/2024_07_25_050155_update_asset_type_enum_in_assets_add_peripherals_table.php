<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Note: MySQL does not support directly modifying enum values via Laravel schema builder
            // Instead, you need to use raw statements to change the enum type
            DB::statement("ALTER TABLE assets MODIFY COLUMN asset_type ENUM('software', 'hardware', 'peripherals')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            DB::statement("ALTER TABLE assets MODIFY COLUMN asset_type ENUM('software', 'hardware')");
        });
    }
};
