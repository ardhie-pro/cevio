<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarisModel extends Model
{
    protected $table = 'inventaris';
    protected $fillable = [
        'vendor',
        'no_telepon',
        'pic',
    ];
}
