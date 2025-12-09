<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarikModul extends Model
{
    use HasFactory;

    protected $table = 'tarik_modul';
    protected $fillable = ['modul', 'type_template', 'waktu'];
}
