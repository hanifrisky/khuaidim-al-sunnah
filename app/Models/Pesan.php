<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
        'siswa_id',
        'pesan',
        'action',
        'status'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
