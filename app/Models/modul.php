<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KumpulanModull extends Model
{
    use HasFactory;

    protected $table = 'kumpulan_modul';

    protected $fillable = ['nama', 'modul_ids'];

    protected $casts = [
        'modul_ids' => 'array', // otomatis json decode/encode
    ];
}
