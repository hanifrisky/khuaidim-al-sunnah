<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Hadits extends Model
{
    use Searchable;
    use SoftDeletes;
    protected $fillable = [
        'bab_id',
        'kitab_id',
        'nomor',
        'name',
        'content',
        'content_normalized',
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
