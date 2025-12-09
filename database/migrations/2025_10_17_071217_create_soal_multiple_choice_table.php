<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soal_multiple_choice', function (Blueprint $table) {
            $table->id();
            $table->text('soal')->nullable();
            $table->string('j1')->nullable();
            $table->string('j2')->nullable();
            $table->string('j3')->nullable();
            $table->string('j4')->nullable();
            $table->string('j5')->nullable();
            $table->string('jawaban_benar')->nullable(); // opsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soal_multiple_choice');
    }
};
