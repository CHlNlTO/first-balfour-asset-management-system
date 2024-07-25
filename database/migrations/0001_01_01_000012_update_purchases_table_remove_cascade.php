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
        Schema::table('purchases', function (Blueprint $table) {
            // Drop the foreign keys
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            // Re-add the foreign keys without onDelete('cascade')
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            // Drop the foreign keys
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            // Re-add the foreign keys with onDelete('cascade')
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }
};

