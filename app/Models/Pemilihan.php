<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemilihan extends Model
{
    protected $table = 'pemilihan';

    protected $fillable = [
        'nama',
        'tanggal_pemilihan',
        'kapasitas_tps',
        'status',
    ];

    protected $casts = [
        'tanggal_pemilihan' => 'date',
        'kapasitas_tps' => 'integer',
    ];

    public function tps(): HasMany
    {
        return $this->hasMany(Tps::class, 'pemilihan_id');
    }
}
