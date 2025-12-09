<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soal_multiple_choice', function (Blueprint $table) {
            $table->text('modul')->nullable()->after('jawaban_benar');
        });
    }

    public function down(): void
    {
        Schema::table('soal_multiple_choice', function (Blueprint $table) {
            $table->dropColumn('modul');
        });
    }
};
