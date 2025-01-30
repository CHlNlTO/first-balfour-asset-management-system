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
        Schema::table('lifecycles', function (Blueprint $table) {
            // Drop the existing index
            $table->dropIndex('lifecycle_asset_id_foreign');

            // Add the foreign key constraint with ON DELETE CASCADE
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lifecycles', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['asset_id']);

            // Re-add the original index
            $table->index('asset_id', 'lifecycle_asset_id_foreign');
        });
    }
};
