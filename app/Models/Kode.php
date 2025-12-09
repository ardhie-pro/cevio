<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    use HasFactory;
    protected $table = 'kode';
    protected $fillable = ['kode', 'modul_id', 'waktu', 'status', 'tanggal_mulai', 'tanggal_selesai'];
}
