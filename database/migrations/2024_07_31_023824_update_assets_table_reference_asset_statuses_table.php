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
            $table->unsignedBigInteger('asset_status')->change();
        });

        DB::table('assets')->update(['asset_status' => DB::raw('FLOOR(RAND() * 7) + 1')]);


        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('asset_status')->references('id')->on('asset_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['asset_status']);
            $table->enum('asset_status', ['active', 'inactive', 'under repair', 'in transfer', 'disposed', 'lost', 'stolen'])->change();
        });
    }
};

