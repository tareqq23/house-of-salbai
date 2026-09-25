<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            // Add tanggal_selesai after tanggal_event (nullable so existing rows are not broken)
            $table->date('tanggal_selesai')->nullable()->after('tanggal_event');
        });
    }

    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('tanggal_selesai');
        });
    }
};
