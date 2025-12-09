<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupModel extends Model
{
    // Nama tabel (opsional, tapi baik ditulis karena bukan plural)
    protected $table = 'grup';

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'nama_grup',
    ];
}
