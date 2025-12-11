<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleShift extends Model
{
    protected $fillable = [
        'role_id',
        'jam_mulai',
        'jam_selesai',
        'fee_per_unit'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
