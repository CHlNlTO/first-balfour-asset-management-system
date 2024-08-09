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
        Schema::table('assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_status')->change();
        });

        DB::table('assignments')->update(['assignment_status' => DB::raw('FLOOR(RAND() * 4) + 1')]);


        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('assignment_status')->references('id')->on('assignment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['assignment_status']);
            $table->enum('assignment_status', ['active', 'inactive', 'in transfer'])->change();
        });
    }
};
