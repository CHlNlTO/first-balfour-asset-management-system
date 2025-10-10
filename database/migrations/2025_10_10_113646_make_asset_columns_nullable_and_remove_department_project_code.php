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
        Schema::table('assets', function (Blueprint $table) {
            // Make asset_status nullable
            $table->unsignedBigInteger('asset_status')->nullable()->change();

            // Make model_id nullable
            $table->unsignedBigInteger('model_id')->nullable()->change();

            // Make cost_code nullable (if it exists as a foreign key, we need to handle it differently)
            if (Schema::hasColumn('assets', 'cost_code')) {
                // Check if cost_code is a foreign key or just a string
                $table->string('cost_code')->nullable()->change();
            }

            // Remove department_project_code if it exists
            if (Schema::hasColumn('assets', 'department_project_code')) {
                $table->dropColumn('department_project_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Revert asset_status to not nullable
            $table->unsignedBigInteger('asset_status')->nullable(false)->change();

            // Revert model_id to not nullable
            $table->unsignedBigInteger('model_id')->nullable(false)->change();

            // Revert cost_code to not nullable
            if (Schema::hasColumn('assets', 'cost_code')) {
                $table->string('cost_code')->nullable(false)->change();
            }

            // Re-add department_project_code
            if (!Schema::hasColumn('assets', 'department_project_code')) {
                $table->string('department_project_code')->nullable();
            }
        });
    }
};
