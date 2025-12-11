<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    protected $fillable = [
        'event_id',
        'nominal',
        'keterangan',
        'type',
        'tanggal',
        'metode',
        'nama_pengirim',
        'bukti_tf',
        'approval'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
