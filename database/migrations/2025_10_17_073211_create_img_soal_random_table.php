<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('img_soal_random', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable(); // ✅ kolom gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('img_soal_random');
    }
};
