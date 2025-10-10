<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('software', function (Blueprint $table) {
            // Make both software_type and license_type nullable
            $table->unsignedBigInteger('software_type')->nullable()->change();
            $table->string('license_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('software', function (Blueprint $table) {
            // Revert both columns to not nullable
            $table->unsignedBigInteger('software_type')->nullable(false)->change();
            $table->string('license_type')->nullable(false)->change();
        });
    }
};
