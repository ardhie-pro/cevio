<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KumpulanModul extends Model
{
    use HasFactory;

    protected $table = 'kumpulan_modul';

    protected $fillable = ['nama', 'modul_ids'];

    protected $casts = [
        'modul_ids' => 'array', // otomatis json decode/encode
    ];
}
