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
            $table->foreignId('pc_name_id')->nullable()->constrained('pc_names')->onDelete('set null');
        });

        Schema::table('software', function (Blueprint $table) {
            $table->foreignId('pc_name_id')->nullable()->constrained('pc_names')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->dropColumn('pc_name_id');
        });

        Schema::table('software', function (Blueprint $table) {
            $table->dropColumn('pc_name_id');
        });
    }
};
