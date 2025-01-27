<?php

use App\Models\Project;
use App\Models\Division;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('short_name')->nullable();
            $table->foreignIdFor(Division::class);
            $table->timestamps();
        });

        Schema::create('cost_codes', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->foreignIdFor(Project::class);
            $table->boolean('active')->default(0)->comment('0=not active/1=active');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop cost_codes table if exists
        if (Schema::hasTable('cost_codes')) {
            Schema::dropIfExists('cost_codes');
        }

        // Drop departments_projects table if exists
        if (Schema::hasTable('projects')) {
            Schema::dropIfExists('projects');
        }

        // Drop departments_projects table if exists
        if (Schema::hasTable('departments_projects')) {
            Schema::dropIfExists('departments_projects');
        }

        // Drop divisions table if exists
        if (Schema::hasTable('divisions')) {
            Schema::dropIfExists('divisions');
        }
    }
};
