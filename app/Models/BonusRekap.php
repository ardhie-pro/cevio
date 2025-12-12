<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusRekap extends Model
{
    protected $table = 'bonus_rekap';

    protected $fillable = [
        'user_id',
        'bonus',
        'catatan',
        'updated_by',
        'updated_at'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
