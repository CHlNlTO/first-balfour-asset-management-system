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
        // Modify the sales_invoice_no column in the purchases table from bigInt to string
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('sales_invoice_no')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the sales_invoice_no column back to bigInt
        Schema::table('purchases', function (Blueprint $table) {
            $table->bigInteger('sales_invoice_no')->change();
        });
    }
};
