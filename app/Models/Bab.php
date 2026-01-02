<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bab extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kitab_id',
        'name',
        'description',
        'media'
    ];

    public function kitab()
    {
        return $this->belongsTo(Kitab::class);
    }
}
