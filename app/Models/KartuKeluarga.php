<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    protected $fillable = [
        'no_kk',
        'alamat',
        'rt_id',
    ];

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class);
    }
}