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
        // Convert existing string statuses to integers before changing the column type
        \Illuminate\Support\Facades\DB::table('users')->where('status', 'active')->update(['status' => '1']);
        \Illuminate\Support\Facades\DB::table('users')->where('status', 'inactive')->update(['status' => '0']);

        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });
    }
};
