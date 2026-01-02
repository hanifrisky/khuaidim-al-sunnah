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
        'guru_id',
        'deadline',
        'status'
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function hadits()
    {
        return $this->belongsTo(Hadits::class, 'hadits_id');
    }
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
