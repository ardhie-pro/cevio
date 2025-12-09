<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'project_manager',
        'client',
        'nama_event',
        'lokasi',
        'nilai_project',
        'mulai_pelaksanaan',
        'selesai_pelaksanaan',
        'mulai_persiapan',
        'selesai_persiapan',
        'durasi_pelaksanaan',
        'durasi_persiapan',
        'total_durasi',
    ];
    public function pemasukan()
    {
        return $this->hasMany(Pemasukan::class);
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function kru()
    {
        return $this->hasMany(EventKru::class);
    }

    public function formatJam($jam)
    {
        $hari = intdiv($jam, 24);
        $sisaJam = $jam % 24;

        return $hari . ' hari ' . $sisaJam . ' jam';
    }
}
