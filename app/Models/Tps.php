<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tps extends Model
{
    protected $table = 'tps';

    protected $fillable = [
        'pemilihan_id',
        'nomor',
    ];

    protected $casts = [
        'nomor' => 'integer',
    ];

    public function pemilihan(): BelongsTo
    {
        return $this->belongsTo(Pemilihan::class, 'pemilihan_id');
    }

    public function rts(): BelongsToMany
    {
        return $this->belongsToMany(
            Rt::class,
            'tps_rt',
            'tps_id',
            'rt_id'
        )->withTimestamps();
    }
}
