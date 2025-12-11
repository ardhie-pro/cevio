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
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->enum('type', ['masuk', 'kembali'])->default('masuk');
            $table->date('tanggal')->nullable();
            $table->string('metode')->nullable();
            $table->string('nama_pengirim')->nullable();
            $table->string('bukti_tf')->nullable();
            $table->enum('approval', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
