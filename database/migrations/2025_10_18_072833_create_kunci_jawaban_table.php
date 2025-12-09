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
        Schema::create('kunci_jawaban', function (Blueprint $table) {
            $table->id();
            $table->string('modul_jawaban');      // Nama modul atau kode modul
            $table->string('jawaban_benar');      // Kunci jawaban (misal: A, B, C, D)
            $table->integer('poin_jawaban');      // Nilai poin untuk jawaban ini
            $table->integer('nomor_jawaban');     // Nomor urut soal
            $table->timestamps();                 // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunci_jawaban');
    }
};
