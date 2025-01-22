<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create divisions table
        if (!Schema::hasTable('divisions')) {
            Schema::create('divisions', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique(); // Ensure this column is unique and indexed
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // Create departments_projects table
        if (!Schema::hasTable('departments_projects')) {
            Schema::create('departments_projects', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();  // Ensure the 'code' column is unique
                $table->string('name')->nullable();
                $table->string('division_code');  // Using 'division_code' here instead of 'division_id'
                $table->foreign('division_code')  // Correct foreign key column
                    ->references('code')
                    ->on('divisions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // Create cost_codes table
        if (!Schema::hasTable('cost_codes')) {
            Schema::create('cost_codes', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name')->nullable();
                $table->string('department_project_code');  // Change this to string (match `code` type in `departments_projects`)
                $table->foreign('department_project_code')
                    ->references('code')
                    ->on('departments_projects')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Drop cost_codes table if exists
        if (Schema::hasTable('cost_codes')) {
            Schema::dropIfExists('cost_codes');
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
