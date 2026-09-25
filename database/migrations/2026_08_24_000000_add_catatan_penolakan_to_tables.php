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
        if (!Schema::hasColumn('inventories', 'catatan_penolakan')) {
            Schema::table('inventories', function (Blueprint $table) {
                $table->text('catatan_penolakan')->nullable()->after('approval_status');
            });
        }

        if (!Schema::hasColumn('albums', 'catatan_penolakan')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->text('catatan_penolakan')->nullable()->after('approval_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('inventories', 'catatan_penolakan')) {
            Schema::table('inventories', function (Blueprint $table) {
                $table->dropColumn('catatan_penolakan');
            });
        }

        if (Schema::hasColumn('albums', 'catatan_penolakan')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropColumn('catatan_penolakan');
            });
        }
    }
};
