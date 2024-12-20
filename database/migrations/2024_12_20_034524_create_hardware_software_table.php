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
        Schema::create('hardware_software', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hardware_asset_id')->constrained('hardware', 'asset_id')->onDelete('cascade');
            $table->foreignId('software_asset_id')->constrained('software', 'asset_id')->onDelete('cascade');
            $table->timestamps();

            // Add unique constraint to prevent duplicate relationships
            $table->unique(['hardware_asset_id', 'software_asset_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_software');
    }
};
