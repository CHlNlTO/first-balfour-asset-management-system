<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Fetch all employee id_nums from central_employeedb
        $employees = DB::connection('central_employeedb')
            ->table('employees')
            ->pluck('id_num')
            ->toArray();

        if (empty($employees)) {
            throw new \Exception('No employees found in central_employeedb');
        }

        // Step 2: Drop the foreign key if it exists
        try {
            Schema::table('assignments', function (Blueprint $table) {
                // Attempt to drop the foreign key
                $table->dropForeign(['employee_id']);
            });
        } catch (\Exception $e) {
            // Log the error and proceed if the foreign key does not exist
            Log::warning('Foreign key not found or could not be dropped: ' . $e->getMessage());
        }

        // Step 3: Drop the old employee_id column if it exists
        try {
            Schema::table('assignments', function (Blueprint $table) {
                $table->dropColumn('employee_id');
            });
        } catch (\Exception $e) {
            // Log the error and proceed if the column does not exist
            Log::warning('Column not found or could not be dropped: ' . $e->getMessage());
        }

        // Step 4: Add the new employee_id column
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->after('asset_id');
        });

        // Step 5: Populate assignments with random valid employee id_nums
        DB::table('assignments')->get()->each(function ($assignment) use ($employees) {
            DB::table('assignments')
                ->where('id', $assignment->id)
                ->update(['employee_id' => $employees[array_rand($employees)]]);
        });
    }

    public function down()
    {
        // Reverse the migration steps
        Schema::table('assignments', function (Blueprint $table) {
            // Drop new employee_id column
            $table->dropColumn('employee_id');
            // Re-add old employee_id column with the old type
            $table->unsignedBigInteger('employee_id')->nullable()->after('asset_id');
        });
    }
};
