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
        Schema::table('event_kru', function (Blueprint $table) {
            $table->date('tanggal_kerja')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles');
            $table->foreignId('role_shift_id')->nullable()->constrained('role_shifts');

            $table->integer('fee_per_unit')->nullable();
            $table->integer('jumlah_unit')->default(1);
            $table->integer('total_gaji')->nullable();

            $table->integer('score_performance')->nullable();
            $table->text('catatan_performance')->nullable();
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
