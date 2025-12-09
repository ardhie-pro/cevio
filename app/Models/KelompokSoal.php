<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokSoal extends Model
{
    use HasFactory;

    protected $table = 'kelompok_soal';

    protected $fillable = [
        'judul',
        'persamaan',
        'soal1_text',
        'soal1_img',
        'soal2_text',
        'soal2_img',
        'soal3_text',
        'soal3_img',
        'soal4_text',
        'soal4_img',
        'soal5_text',
        'soal5_img',
    ];
}
