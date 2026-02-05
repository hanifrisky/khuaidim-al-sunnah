<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiSoal extends Model
{
    protected $fillable = [
        'siswa_id',
        'nilai',
        'kitab_id',
    ];

    public function Kitab()
    {
        return $this->belongsTo(Kitab::class);
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
