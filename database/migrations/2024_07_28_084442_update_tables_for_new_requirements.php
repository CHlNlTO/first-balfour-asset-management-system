<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update 'assets' table
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'assignments' table
        Schema::table('assignments', function (Blueprint $table) {
            $table->date('end_date')->nullable()->change();
            if (!Schema::hasColumn('assignments', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'hardware' table
        Schema::table('hardware', function (Blueprint $table) {
            if (!Schema::hasColumn('hardware', 'hardware_type')) {
                $table->foreignId('hardware_type')->nullable()->constrained('hardware_types');
            }
            if (Schema::hasColumn('hardware', 'warranty_expiration')) {
                $table->date('warranty_expiration')->nullable()->change();
            }
            if (!Schema::hasColumn('hardware', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'lifecycles' table
        Schema::table('lifecycles', function (Blueprint $table) {
            if (Schema::hasColumn('lifecycles', 'retirement_date')) {
                $table->date('retirement_date')->nullable()->change();
            }
            if (!Schema::hasColumn('lifecycles', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'peripherals' table
        Schema::table('peripherals', function (Blueprint $table) {
            if (!Schema::hasColumn('peripherals', 'peripheral_type')) {
                $table->foreignId('peripheral_type')->nullable()->constrained('peripherals_types');
            }
            if (Schema::hasColumn('peripherals', 'warranty_expiration')) {
                $table->date('warranty_expiration')->nullable()->change();
            }
            if (!Schema::hasColumn('peripherals', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'purchases' table
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'purchase_order_no')) {
                $table->string('purchase_order_no');
            }
            if (Schema::hasColumn('purchases', 'receipt_no')) {
                $table->renameColumn('receipt_no', 'sales_invoice_no');
            }
            if (Schema::hasColumn('purchases', 'purchase_cost')) {
                $table->renameColumn('purchase_cost', 'purchase_order_amount');
            }
            if (Schema::hasColumn('purchases', 'purchase_date')) {
                $table->renameColumn('purchase_date', 'purchase_order_date');
            }
            if (!Schema::hasColumn('purchases', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'software' table
        Schema::table('software', function (Blueprint $table) {
            if (!Schema::hasColumn('software', 'software_type')) {
                $table->foreignId('software_type')->nullable()->constrained('software_types');
            }
            if (Schema::hasColumn('software', 'version')) {
                $table->string('version')->nullable()->change();
            }
            if (Schema::hasColumn('software', 'license_key')) {
                $table->string('license_key')->nullable()->change();
            }
            if (!Schema::hasColumn('software', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });

        // Update 'vendors' table
        Schema::table('vendors', function (Blueprint $table) {
            if (Schema::hasColumn('vendors', 'city')) {
                $table->string('city')->nullable()->change();
            }
            if (Schema::hasColumn('vendors', 'tel_no_1')) {
                $table->string('tel_no_1')->nullable()->change();
            }
            if (Schema::hasColumn('vendors', 'contact_person')) {
                $table->string('contact_person')->nullable()->change();
            }
            if (Schema::hasColumn('vendors', 'mobile_number')) {
                $table->string('mobile_number')->nullable()->change();
            }
            if (Schema::hasColumn('vendors', 'email')) {
                $table->string('email')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverse changes made in 'assets' table
        Schema::table('assets', function (Blueprint $table) {
            if (Schema::hasColumn('assets', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'assignments' table
        Schema::table('assignments', function (Blueprint $table) {
            $table->date('end_date')->nullable(false)->change();
            if (Schema::hasColumn('assignments', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'hardware' table
        Schema::table('hardware', function (Blueprint $table) {
            if (Schema::hasColumn('hardware', 'hardware_type')) {
                $table->dropConstrainedForeignId('hardware_type');
            }
            if (Schema::hasColumn('hardware', 'warranty_expiration')) {
                $table->date('warranty_expiration')->nullable(false)->change();
            }
            if (Schema::hasColumn('hardware', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'lifecycles' table
        Schema::table('lifecycles', function (Blueprint $table) {
            if (Schema::hasColumn('lifecycles', 'retirement_date')) {
                $table->date('retirement_date')->nullable(false)->change();
            }
            if (Schema::hasColumn('lifecycles', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'peripherals' table
        Schema::table('peripherals', function (Blueprint $table) {
            if (Schema::hasColumn('peripherals', 'peripheral_type')) {
                $table->dropConstrainedForeignId('peripheral_type');
            }
            if (Schema::hasColumn('peripherals', 'warranty_expiration')) {
                $table->date('warranty_expiration')->nullable(false)->change();
            }
            if (Schema::hasColumn('peripherals', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'purchases' table
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'purchase_order_no')) {
                $table->dropColumn('purchase_order_no');
            }
            if (Schema::hasColumn('purchases', 'sales_invoice_no')) {
                $table->renameColumn('sales_invoice_no', 'receipt_no');
            }
            if (Schema::hasColumn('purchases', 'purchase_order_amount')) {
                $table->renameColumn('purchase_order_amount', 'purchase_cost');
            }
            if (Schema::hasColumn('purchases', 'purchase_order_date')) {
                $table->renameColumn('purchase_order_date', 'purchase_date');
            }
            if (Schema::hasColumn('purchases', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'software' table
        Schema::table('software', function (Blueprint $table) {
            if (Schema::hasColumn('software', 'software_type')) {
                $table->dropConstrainedForeignId('software_type');
            }
            if (Schema::hasColumn('software', 'version')) {
                $table->string('version')->nullable(false)->change();
            }
            if (Schema::hasColumn('software', 'license_key')) {
                $table->string('license_key')->nullable(false)->change();
            }
            if (Schema::hasColumn('software', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });

        // Reverse changes made in 'vendors' table
        Schema::table('vendors', function (Blueprint $table) {
            if (Schema::hasColumn('vendors', 'city')) {
                $table->string('city')->nullable(false)->change();
            }
            if (Schema::hasColumn('vendors', 'tel_no_1')) {
                $table->string('tel_no_1')->nullable(false)->change();
            }
            if (Schema::hasColumn('vendors', 'contact_person')) {
                $table->string('contact_person')->nullable(false)->change();
            }
            if (Schema::hasColumn('vendors', 'mobile_number')) {
                $table->string('mobile_number')->nullable(false)->change();
            }
            if (Schema::hasColumn('vendors', 'email')) {
                $table->string('email')->nullable(false)->change();
            }
        });
    }
};
