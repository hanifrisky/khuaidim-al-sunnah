<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = [
        'hadits_id',
        'tipe',
        'soal',
        'media'
    ];

    public function hadits()
    {
        return $this->belongsTo(Hadits::class, 'hadits_id');
    }

    public function getHaditsNameAttribute()
    {
        return $this->hadits ? $this->hadits->name : '-';
    }

    public function jawaban()
    {
        return $this->hasMany(PilihanJawaban::class, 'soal_id');
    }
}
