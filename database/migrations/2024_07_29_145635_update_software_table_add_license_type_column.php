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
            if (!Schema::hasColumn('software', 'license_type')) {
                $table->foreignId('license_type')->nullable()->constrained('license_types');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('software', function (Blueprint $table) {
            if (Schema::hasColumn('software', 'license_type')) {
                $table->dropColumn('license_type')->nullable()->constrained('license_types');
            }
        });
    }
};
