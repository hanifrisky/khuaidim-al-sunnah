<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetoranHafalan extends Model
{
    protected $fillable = [
        'tugas_hafalan_id',
        'siswa_id',
        'media',
        'status',
        'keterangan'
    ];

    public function tugasHafalan()
    {
        return $this->belongsTo(TugasHafalan::class, 'tugas_hafalan_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
