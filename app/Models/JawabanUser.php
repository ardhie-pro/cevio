<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUser extends Model
{
    use HasFactory;
    protected $table = 'jawaban_user';

    protected $fillable = [
        'user_id',
        'modul',
        'no',
        'jawaban'
    ];
}
