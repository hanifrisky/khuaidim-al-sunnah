<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'identitas',
        'kelas_id',
        'jenis_kelamin',
        'telp',
    ];
    protected $with = ['user'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn() => $this->user->name,
    //         set: function ($value) {
    //             if ($this->user) {
    //                 $this->user->update([
    //                     'name' => $value,
    //                 ]);
    //             }
    //         }
    //     );
    // }
}
