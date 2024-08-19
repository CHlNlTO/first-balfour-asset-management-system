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
            // First, drop the existing foreign key constraint
            $table->dropForeign(['asset_id']);

            // Then, re-add the foreign key with cascading delete and update
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade')   // This will add ON DELETE CASCADE
                ->onUpdate('cascade');  // This will add ON UPDATE CASCADE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            // Drop the cascade foreign key
            $table->dropForeign(['asset_id']);

            // Re-add the original foreign key without cascading
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets');
        });
    }
};
