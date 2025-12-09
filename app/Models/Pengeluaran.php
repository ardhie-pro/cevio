<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'event_id',
        'nominal',
        'keterangan'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
