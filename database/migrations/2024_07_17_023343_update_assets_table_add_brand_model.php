<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAssetsTableAddBrandModel extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('asset_status');
            $table->string('model')->nullable()->after('brand');
        });

        Schema::table('hardware', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model']);
        });

        Schema::table('software', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model']);
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model']);
        });

        Schema::table('hardware', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
        });

        Schema::table('software', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
        });
    }
}
