<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventKru extends Model
{
    protected $table = 'event_kru';

    protected $fillable = [
        'event_id',
        'user_id',
        'tanggal_kerja',
        'role_id',
        'role_shift_id',
        'fee_per_unit',
        'jumlah_unit',
        'total_gaji',
        'score_performance',
        'catatan_performance'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roleShift()
    {
        return $this->belongsTo(RoleShift::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function eventKru()
    {
        return $this->hasMany(EventKru::class, 'user_id');
    }
}
