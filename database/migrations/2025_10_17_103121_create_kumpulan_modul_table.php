<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kumpulan_modul', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // nama kumpulan modul
            $table->json('modul_ids')->nullable(); // simpan id modul yang dicentang dari tarik_modul
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kumpulan_modul');
    }
};
