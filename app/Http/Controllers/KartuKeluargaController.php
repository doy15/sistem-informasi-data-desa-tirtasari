<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Rt;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    public function create()
    {
        $rts = Rt::with('rw.dusun')
            ->orderBy('nomor')
            ->get();

        $rtData = $rts->mapWithKeys(function ($rt) {
            return [
                $rt->id => [
                    'rt' => $rt->nomor,
                    'rw' => $rt->rw?->nomor,
                    'dusun' => $rt->rw?->dusun?->nama,
                ],
            ];
        })->toArray();

        return view('keluarga.create', [
            'rts' => $rts,
            'rtData' => $rtData,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => [
                'required',
                'digits:16',
                'unique:kartu_keluargas,no_kk',
            ],

            'alamat' => [
                'required',
                'string',
                'max:500',
            ],

            'rt_id' => [
                'required',
                'exists:rts,id',
            ],
        ]);

        KartuKeluarga::create([
            'no_kk' => $validated['no_kk'],
            'alamat' => trim($validated['alamat']),
            'rt_id' => $validated['rt_id'],
        ]);

        return redirect()
            ->route('keluarga.index')
            ->with('success', 'Kartu Keluarga berhasil ditambahkan.');
    }
}