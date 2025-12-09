<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalMultipleChoice extends Model
{
    use HasFactory;

    protected $table = 'soal_multiple_choice';

    protected $fillable = [
        'no',
        'soal',
        'j1',
        'j2',
        'j3',
        'j4',
        'j5',
        'jawaban_benar',
        'modul',
        'pembahasan',
        'check',
    ];

    /**
     * Accessor: otomatis ubah src="/storage" jadi src="http://IP_kamu/storage"
     */
    public function getSoalAttribute($value)
    {
        return str_replace('src="/storage', 'src="' . url('/storage'), $value);
    }

    /**
     * (Opsional) kalau kamu juga mau pembahasan tampil dengan gambar aktif
     */
    public function getPembahasanAttribute($value)
    {
        return str_replace('src="/storage', 'src="' . url('/storage'), $value);
    }
}
