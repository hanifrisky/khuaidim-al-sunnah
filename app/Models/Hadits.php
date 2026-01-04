<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hadits extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'bab_id',
        'kitab_id',
        'title',
        'content',
        'keterangan',
        'source',
        'translate',
        'media'
    ];
    protected $with = ['bab', 'kitab'];

    public function bab()
    {
        return $this->belongsTo(Bab::class, 'bab_id');
    }
    public function kitab()
    {
        return $this->belongsTo(Kitab::class, 'kitab_id');
    }
}
