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
        Schema::table('peripherals', function (Blueprint $table) {
            if (!Schema::hasColumn('peripherals', 'peripheral_type')) {
                $table->foreignId('peripherals_type')->nullable()->constrained('peripherals_types');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Reverse changes made in 'peripherals' table
         Schema::table('peripherals', function (Blueprint $table) {
            if (Schema::hasColumn('peripherals', 'peripheral_type')) {
                $table->dropConstrainedForeignId('peripherals_type');
            }
        });
    }
};
