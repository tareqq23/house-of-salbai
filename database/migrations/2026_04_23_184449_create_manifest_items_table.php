<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manifest_items', function (Blueprint $row) {
            $row->id();
            $row->foreignId('manifest_id')->constrained()->onDelete('cascade');
            $row->foreignId('inventory_id')->constrained()->onDelete('cascade');
            $row->integer('qty');
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manifest_items');
    }
};
