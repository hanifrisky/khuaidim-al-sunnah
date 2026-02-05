<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetoranHafalan extends Model
{
    protected $fillable = [
        'tugas_hafalan_id',
        'siswa_id',
        'hadit_id',
        'media',
        'status',
        'keterangan',
        'kelas_id',
        'bab_id'
    ];

    public function tugasHafalan()
    {
        return $this->belongsTo(TugasHafalan::class, 'tugas_hafalan_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function hadits()
    {
        return $this->belongsTo(Hadits::class, 'hadit_id');
    }
}
