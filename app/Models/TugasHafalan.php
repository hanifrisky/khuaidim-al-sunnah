<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasHafalan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'siswa_id',
        'kelas_id',
        'hadits_id',
        'bab_id',
        'guru_id',
        'deadline',
        'status'
    ];
    protected $with = ['guru', 'kelas', 'siswa', 'hadits', 'bab'];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function SetoranHafalan()
    {
        return $this->hasMany(SetoranHafalan::class);
    }
    public function hadits()
    {
        return $this->belongsTo(Hadits::class, 'hadits_id');
    }
    public function bab()
    {
        return $this->belongsTo(Bab::class, 'bab_id');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
    public function getGuruNameAttribute()
    {
        return $this->guru->name;
    }
    public function getSiswaNameAttribute()
    {
        return $this->siswa->name;
    }
    public function getKelasNameAttribute()
    {
        return $this->kelas->name;
    }
}
