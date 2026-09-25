<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manifests', function (Blueprint $description) {
            $description->id();
            $description->string('nomor_manifes');
            $description->string('klien_event');
            $description->date('tanggal_loading');
            $description->string('crew_chief');
            $description->string('status')->default('Alat Diluar');
            $description->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manifests');
    }
};
