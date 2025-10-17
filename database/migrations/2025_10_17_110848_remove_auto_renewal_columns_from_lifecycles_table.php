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
            $table->dropColumn(['auto_renewal_enabled', 'renewal_in_progress']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lifecycles', function (Blueprint $table) {
            $table->boolean('auto_renewal_enabled')->default(false);
            $table->boolean('renewal_in_progress')->default(false);
        });
    }
};
