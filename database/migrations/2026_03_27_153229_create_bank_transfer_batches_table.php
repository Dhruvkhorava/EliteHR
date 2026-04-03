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
        Schema::create('bank_transfer_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no')->unique();
            $table->decimal('total_amount', 15, 2);
            $table->integer('employee_count');
            $table->string('bank_name');
            $table->string('status')->default('pending'); // pending, processed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transfer_batches');
    }
};
