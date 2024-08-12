<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Add a new column for the string employee_id
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'new_employee_id')) {
                $table->string('new_employee_id')->nullable()->after('employee_id');
            }
        });

        // Step 2: Fetch data from remote database and update local database
        $assignments = DB::table('assignments')->get();
        foreach ($assignments as $assignment) {
            $employee = DB::connection('central_employeedb')
                ->table('employees')
                ->where('id', $assignment->employee_id)
                ->first();

            if ($employee) {
                DB::table('assignments')
                    ->where('id', $assignment->id)
                    ->update(['new_employee_id' => $employee->id_num]);
            }
        }

        // Step 3: Attempt to drop the foreign key if it exists
        $this->dropForeignKeyIfExists('assignments', 'assignments_employee_id_foreign');

        // Step 4: Drop the old column
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });

        // Step 5: Rename the new column
        Schema::table('assignments', function (Blueprint $table) {
            $table->renameColumn('new_employee_id', 'employee_id');
        });
    }

    public function down()
    {
        // Reverse the changes if needed
        Schema::table('assignments', function (Blueprint $table) {
            $table->renameColumn('employee_id', 'new_employee_id');
            $table->unsignedBigInteger('employee_id')->after('asset_id');
        });

        // Fetch data from remote database and update local database
        $assignments = DB::table('assignments')->get();
        foreach ($assignments as $assignment) {
            $employee = DB::connection('central_employeedb')
                ->table('employees')
                ->where('id_num', $assignment->new_employee_id)
                ->first();

            if ($employee) {
                DB::table('assignments')
                    ->where('id', $assignment->id)
                    ->update(['employee_id' => $employee->id]);
            }
        }

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('new_employee_id');
        });
    }

    private function dropForeignKeyIfExists($table, $foreignKey)
    {
        try {
            Schema::table($table, function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey);
            });
        } catch (\Exception $e) {
            // Foreign key doesn't exist, so we can ignore this exception
        }
    }
};