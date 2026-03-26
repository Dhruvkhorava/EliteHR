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
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->longText('message');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred_sender')->default(false);
            $table->boolean('is_starred_receiver')->default(false);
            $table->boolean('is_draft')->default(false);
            $table->boolean('is_trashed_sender')->default(false);
            $table->boolean('is_trashed_receiver')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mails');
    }
};
