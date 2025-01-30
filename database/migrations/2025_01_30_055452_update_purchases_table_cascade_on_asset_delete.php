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
        Schema::table('purchases', function (Blueprint $table) {
            // Ensure the foreign key does not already exist to avoid conflicts
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade'); // Add cascade on delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            // Safely drop the foreign key
            $table->dropForeign(['asset_id']);
        });
    }
};
