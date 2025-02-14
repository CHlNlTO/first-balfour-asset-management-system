<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lifecycles', function (Blueprint $table) {
            $table->boolean('auto_renewal_enabled')->default(false)->after('retirement_date');
            $table->boolean('renewal_in_progress')->default(false)->after('auto_renewal_enabled');
        });
    }

    public function down()
    {
        Schema::table('lifecycles', function (Blueprint $table) {
            $table->dropColumn('auto_renewal_enabled');
            $table->dropColumn('renewal_in_progress');
        });
    }
};
