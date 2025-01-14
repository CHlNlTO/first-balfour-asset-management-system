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
            $table->string('manufacturer')->nullable()->change();
        });

        Schema::table('peripherals', function (Blueprint $table) {
            $table->string('manufacturer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->string('manufacturer')->nullable(false)->change();
        });
        Schema::table('peripherals', function (Blueprint $table) {
            $table->string('manufacturer')->nullable(false)->change();
        });
    }
};
