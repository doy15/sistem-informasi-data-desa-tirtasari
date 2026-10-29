<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penduduk extends Model
{
    protected $fillable = [
        'nik',
        'kartu_keluarga_id',
        'nama_lengkap',
        'status_hubungan_keluarga',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'agama',
        'pendidikan_akhir',
        'jenis_pekerjaan',
        'status_perkawinan',
        'nama_ibu',
        'nama_ayah',
        'no_paspor',
        'tanggal_akhir_paspor',
        'hb',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_akhir_paspor' => 'date',
    ];

    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
}