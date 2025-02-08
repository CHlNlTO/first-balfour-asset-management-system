<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('asset_statuses', function (Blueprint $table) {
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('asset_statuses', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropColumn('color_id');
        });
    }
};
