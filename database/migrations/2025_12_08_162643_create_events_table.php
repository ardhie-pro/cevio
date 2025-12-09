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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('project_manager');
            $table->string('client');
            $table->string('nama_event');
            $table->string('lokasi');
            $table->decimal('nilai_project', 15, 2)->nullable();

            // waktu
            $table->date('mulai_pelaksanaan')->nullable();
            $table->date('selesai_pelaksanaan')->nullable();
            $table->date('mulai_persiapan')->nullable();
            $table->date('selesai_persiapan')->nullable();

            // durasi
            $table->integer('durasi_pelaksanaan')->nullable();
            $table->integer('durasi_persiapan')->nullable();
            $table->integer('total_durasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
