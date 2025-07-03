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
        // First drop the existing table if it exists
        Schema::dropIfExists('purchases');

        // Then create the new table with the desired structure
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('sales_invoice_no', 10);
            $table->string('purchase_order_no', 10);
            $table->bigInteger('purchase_order_amount');
            $table->date('purchase_order_date');
            $table->unsignedBigInteger('vendor_id');
            $table->string('requestor', 255)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->timestamps();
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};