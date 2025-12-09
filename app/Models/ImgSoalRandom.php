<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgSoalRandom extends Model
{
    use HasFactory;

    protected $table = 'img_soal_random';

    protected $fillable = [
        'img',
    ];
}
