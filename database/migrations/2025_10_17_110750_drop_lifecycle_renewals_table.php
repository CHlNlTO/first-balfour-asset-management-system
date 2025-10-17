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
        Schema::dropIfExists('lifecycle_renewals');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('lifecycle_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lifecycle_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Using DATETIME instead of TIMESTAMP for better compatibility
            // DATETIME doesn't have the 2038 problem and timezone complexities of TIMESTAMP
            $table->datetime('old_retirement_date');
            $table->datetime('new_retirement_date');

            $table->boolean('is_automatic')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Index for faster queries
            $table->index(['lifecycle_id', 'created_at']);
        });
    }
};
