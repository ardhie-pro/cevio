<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunciJawaban extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi)
    protected $table = 'kunci_jawaban';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'modul_jawaban',
        'jawaban_benar',
        'poin_jawaban',
        'nomor_jawaban',
    ];
}
