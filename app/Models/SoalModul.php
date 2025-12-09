<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalModul extends Model
{
    use HasFactory;
    protected $table = 'soal_modul';
    protected $fillable = [
        'no', 'kelompok', 'modul', 'soal1', 'soal2', 'j1', 'j2', 'j3', 'j4', 'j5'
    ];
}
