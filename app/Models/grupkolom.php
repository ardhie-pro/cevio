<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupkolom extends Model
{
    protected $table = 'grup_kolom';

    protected $fillable = [
        'id',
        'nama_grup',
        'isi'
    ];
}
