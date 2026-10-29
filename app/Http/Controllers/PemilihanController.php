<?php

namespace App\Http\Controllers;

use App\Models\Pemilihan;
use App\Models\Tps;
use App\Models\TpsRt;
use App\Models\Rt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PemilihanController extends Controller
{
    public function index()
    {
        $pemilihan = Pemilihan::withCount('tps')
            ->orderByDesc('tanggal_pemilihan')
            ->get();

        return view('pemilihan.index', compact('pemilihan'));
    }

    public function create()
    {
        return view('pemilihan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_pemilihan' => ['required', 'date'],
            'kapasitas_tps' => ['required', 'integer', 'min:1'],
        ]);

        $validated['status'] = 'draft';

        Pemilihan::create($validated);

        return redirect()
            ->route('pemilihan.index')
            ->with('success', 'Pemilihan berhasil ditambahkan.');
    }

    public function show(Pemilihan $pemilihan)
    {
        $pemilihan->load([
            'tps' => fn ($query) => $query->orderBy('nomor'),
            'tps.rts',
        ]);

        $rts = Rt::with('rw')
            ->orderBy('rw_id')
            ->orderBy('nomor')
            ->get();

        $rtTerpakai = TpsRt::whereHas('tps', function ($query) use ($pemilihan) {
            $query->where('pemilihan_id', $pemilihan->id);
        })->pluck('rt_id')->unique()->all();

        return view('pemilihan.show', compact(
            'pemilihan',
            'rts',
            'rtTerpakai'
        ));
    }

    public function storeTps(Request $request, Pemilihan $pemilihan)
    {
        $validated = $request->validate([
            'nomor' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tps', 'nomor')
                    ->where('pemilihan_id', $pemilihan->id),
            ],
        ]);

        $pemilihan->tps()->create($validated);

        return redirect()
            ->route('pemilihan.show', $pemilihan)
            ->with('success', 'TPS berhasil ditambahkan.');
    }

    public function updateRt(
        Request $request,
        Pemilihan $pemilihan,
        Tps $tps
    ) {
        abort_unless(
            (int) $tps->pemilihan_id === (int) $pemilihan->id,
            404
        );

        $validated = $request->validate([
            'rt_ids' => ['nullable', 'array'],
            'rt_ids.*' => ['integer', 'distinct', 'exists:rts,id'],
        ]);

        $rtIds = $validated['rt_ids'] ?? [];

        // Pastikan RT tidak dialokasikan ke TPS lain dalam pemilihan ini.
        foreach ($rtIds as $rtId) {
            $sudahDipakai = TpsRt::where('rt_id', $rtId)
                ->whereHas('tps', function ($query) use ($pemilihan) {
                    $query->where('pemilihan_id', $pemilihan->id);
                })
                ->where('tps_id', '!=', $tps->id)
                ->exists();

            if ($sudahDipakai) {
                return back()
                    ->withErrors([
                        'rt_ids' => "RT ID {$rtId} sudah dialokasikan ke TPS lain pada pemilihan ini.",
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($tps, $rtIds) {
            $tps->rts()->sync($rtIds);
        });

        return redirect()
            ->route('pemilihan.show', $pemilihan)
            ->with('success', 'Alokasi RT berhasil disimpan.');
    }
}
