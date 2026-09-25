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
            $table->string('role')->default('pegawai')->after('email');
        });

        // Set all existing users to admin
        DB::table('users')->update(['role' => 'admin']);

        Schema::table('inventories', function (Blueprint $table) {
            $table->string('approval_status')->default('approved')->after('kondisi_alat');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->string('approval_status')->default('approved')->after('cover_album');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};
