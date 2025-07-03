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
            // First drop the existing foreign key
            $table->dropForeign(['asset_id']);
            
            // Then add the new one with cascade delete
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lifecycles', function (Blueprint $table) {
            // Drop the cascade delete foreign key
            $table->dropForeign(['asset_id']);
            
            // Add back the original foreign key without cascade delete
            $table->foreign('asset_id')->references('id')->on('assets');
        });
    }
};