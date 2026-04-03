<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable()->after('designation');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
        });

        // Migrate existing designation strings to the new table
        $users = DB::table('users')->whereNotNull('designation')->get();
        foreach ($users as $user) {
            $designationName = trim($user->designation);
            if ($designationName) {
                $designation = DB::table('designations')->where('name', $designationName)->first();
                if (!$designation) {
                    $id = DB::table('designations')->insertGetId([
                        'name' => $designationName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $id = $designation->id;
                }
                DB::table('users')->where('id', $user->id)->update(['designation_id' => $id]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('designation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->nullable()->after('email');
        });

        // Optional: restore data from designations table to designation string
        $users = DB::table('users')->whereNotNull('designation_id')->get();
        foreach ($users as $user) {
            $designation = DB::table('designations')->find($user->designation_id);
            if ($designation) {
                DB::table('users')->where('id', $user->id)->update(['designation' => $designation->name]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['designation_id']);
            $table->dropColumn('designation_id');
        });
    }
};
