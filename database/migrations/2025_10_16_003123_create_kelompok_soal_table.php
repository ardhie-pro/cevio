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
        Schema::create('kelompok_soal', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();

            // Tiap soal bisa teks atau gambar, jadi dua kolom
            for ($i = 1; $i <= 5; $i++) {
                $table->text("soal{$i}_text")->nullable();
                $table->string("soal{$i}_img")->nullable(); // path image
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_soal');
    }
};
