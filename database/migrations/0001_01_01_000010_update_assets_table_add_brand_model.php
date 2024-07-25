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
            // Check if the column 'brand' does not exist before adding it
            if (!Schema::hasColumn('assets', 'brand')) {
                $table->string('brand')->nullable()->after('asset_status');
            }

            // Check if the column 'model' does not exist before adding it
            if (!Schema::hasColumn('assets', 'model')) {
                $table->string('model')->nullable()->after('brand');
            }
        });

        // Dropping and re-adding foreign key constraints on purchases table
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Remove columns if they exist
            if (Schema::hasColumn('assets', 'brand')) {
                $table->dropColumn('brand');
            }
            if (Schema::hasColumn('assets', 'model')) {
                $table->dropColumn('model');
            }
        });

        // Revert foreign key constraints on purchases table
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }
};
