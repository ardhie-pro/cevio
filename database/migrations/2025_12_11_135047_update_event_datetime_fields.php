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
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('mulai_pelaksanaan')->change();
            $table->dateTime('selesai_pelaksanaan')->change();
            $table->dateTime('mulai_persiapan')->change();
            $table->dateTime('selesai_persiapan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->date('mulai_pelaksanaan')->change();
            $table->date('selesai_pelaksanaan')->change();
            $table->date('mulai_persiapan')->change();
            $table->date('selesai_persiapan')->change();
        });
    }
};
