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
        Schema::table('hardware', function (Blueprint $table) {
            $table->string('mac_address')->nullable()->after('serial_number');
            $table->string('accessories')->nullable()->after('mac_address');
            $table->string('pc_name')->nullable()->after('accessories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->dropColumn(['mac_address', 'accessories', 'pc_name']);
        });
    }
};
