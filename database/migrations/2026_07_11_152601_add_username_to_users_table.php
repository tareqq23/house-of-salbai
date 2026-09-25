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
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('name');
            });
        }

        // Set unique usernames for existing users based on email prefix
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $prefix = explode('@', $user->email)[0];
            DB::table('users')->where('id', $user->id)->update(['username' => $prefix]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            $table->string('email')->nullable(false)->change();
        });
    }
};
