<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function create()
    {
        $kartuKeluargas = KartuKeluarga::with([
            'penduduks',
            'rt.rw.dusun',
        ])
            ->orderBy('no_kk')
            ->get();

        return view('penduduk.create', [
            'kartuKeluargas' => $kartuKeluargas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'digits:16',
                'unique:penduduks,nik',
            ],

            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'kartu_keluarga_id' => [
                'required',
                'exists:kartu_keluargas,id',
            ],

            'status_hubungan_keluarga' => [
                'required',
                'string',
                'max:100',
            ],

            'jenis_kelamin' => [
                'required',
                'string',
                'max:20',
            ],

            'tempat_lahir' => [
                'required',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
            ],

            'golongan_darah' => [
                'nullable',
                'string',
                'max:20',
            ],

            'agama' => [
                'nullable',
                'string',
                'max:50',
            ],

            'pendidikan_akhir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'jenis_pekerjaan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status_perkawinan' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nama_ibu' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nama_ayah' => [
                'nullable',
                'string',
                'max:255',
            ],

            'no_paspor' => [
                'nullable',
                'string',
                'max:50',
            ],

            'tanggal_akhir_paspor' => [
                'nullable',
                'date',
            ],

            'hb' => [
                'nullable',
                'string',
                'max:50',
            ],
        ]);

        Penduduk::create($validated);

        return redirect()
            ->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PENDUDUK
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $penduduk = Penduduk::with([
            'kartuKeluarga.rt.rw.dusun',
        ])->findOrFail($id);

        $kartuKeluargas = KartuKeluarga::with([
            'penduduks',
            'rt.rw.dusun',
        ])
            ->orderBy('no_kk')
            ->get();

        return view('penduduk.edit', [
            'penduduk' => $penduduk,
            'kartuKeluargas' => $kartuKeluargas,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PENDUDUK
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $validated = $request->validate([
            'nik' => [
                'required',
                'digits:16',
                'unique:penduduks,nik,' . $penduduk->id,
            ],

            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'kartu_keluarga_id' => [
                'required',
                'exists:kartu_keluargas,id',
            ],

            'status_hubungan_keluarga' => [
                'required',
                'string',
                'max:100',
            ],

            'jenis_kelamin' => [
                'required',
                'string',
                'max:20',
            ],

            'tempat_lahir' => [
                'required',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
            ],

            'golongan_darah' => [
                'nullable',
                'string',
                'max:20',
            ],

            'agama' => [
                'nullable',
                'string',
                'max:50',
            ],

            'pendidikan_akhir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'jenis_pekerjaan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status_perkawinan' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nama_ibu' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nama_ayah' => [
                'nullable',
                'string',
                'max:255',
            ],

            'no_paspor' => [
                'nullable',
                'string',
                'max:50',
            ],

            'tanggal_akhir_paspor' => [
                'nullable',
                'date',
            ],

            'hb' => [
                'nullable',
                'string',
                'max:50',
            ],
        ]);

        $penduduk->update($validated);

        return redirect()
            ->route('penduduk.show', $penduduk->id)
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }
}