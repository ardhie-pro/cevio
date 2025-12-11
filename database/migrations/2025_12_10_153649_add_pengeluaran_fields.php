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
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('kategori')->nullable();
            $table->string('item')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('tipe_pembayaran')->nullable();
            $table->decimal('jumlah', 15, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('pic')->nullable();
            $table->string('vendor')->nullable();
            $table->string('invoice')->nullable();
            $table->string('bukti_tf')->nullable();
            $table->string('payment_status')->nullable();
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
