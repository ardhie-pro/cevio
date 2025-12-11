<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'event_id',
        'tanggal_pembayaran',
        'kategori',
        'item',
        'deskripsi',
        'tipe_pembayaran',
        'jumlah',
        'payment_method',
        'pic',
        'vendor',
        'invoice',
        'bukti_tf',
        'payment_status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
