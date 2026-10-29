<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dusun extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function rws(): HasMany
    {
        return $this->hasMany(Rw::class);
    }
}