<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kitab extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'author',
        'description',
        'media'
    ];

    public function babs()
    {
        return $this->hasMany(Bab::class, 'kitab_id');
    }
}
