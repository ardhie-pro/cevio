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
         Schema::create('soal_modul', function (Blueprint $table) {
            $table->id(); // id utama
            $table->string('no_modul')->nullable(); // kode atau nomor modul
            $table->text('soal1')->nullable(); // pertanyaan 1
            $table->text('soal2')->nullable(); // pertanyaan 2 (bisa diperbanyak nanti)
            $table->string('j1')->nullable(); // jawaban A
            $table->string('j2')->nullable(); // jawaban B
            $table->string('j3')->nullable(); // jawaban C
            $table->string('j4')->nullable(); // jawaban D
            $table->string('j5')->nullable(); // jawaban E
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_modul');

    }
};
