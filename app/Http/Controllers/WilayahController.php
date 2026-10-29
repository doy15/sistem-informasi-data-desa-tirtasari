<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WilayahController extends Controller
{
    

public function index()
{
    $dusuns = Dusun::orderBy('nama')->get();

    $semuaRw = \App\Models\Rw::with(['dusun', 'rts.dusun'])
        ->orderBy('nomor')
        ->get();

    foreach ($dusuns as $dusun) {
        $rwUntukDusun = $semuaRw->map(function ($rw) use ($dusun) {
            $rtsUntukDusun = $rw->rts->filter(function ($rt) use ($dusun, $rw) {
                $dusunEfektifId = $rt->dusun_id ?? $rw->dusun_id;

                return (int) $dusunEfektifId === (int) $dusun->id;
            })->values();

            if (
                $rtsUntukDusun->isNotEmpty()
                || (int) $rw->dusun_id === (int) $dusun->id
            ) {
                $rwTampilan = clone $rw;
                $rwTampilan->setRelation('rts', $rtsUntukDusun);

                return $rwTampilan;
            }

            return null;
        })->filter()->values();

        $dusun->setRelation('rws', $rwUntukDusun);
    }

    return view('wilayah.index', [
        'dusuns' => $dusuns,
    ]);
}




    // =========================
    // DUSUN
    // =========================

    public function storeDusun(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                'unique:dusuns,nama',
            ],
        ]);

        Dusun::create([
            'nama' => trim($validated['nama']),
        ]);

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Dusun berhasil ditambahkan.');
    }

    public function updateDusun(Request $request, Dusun $dusun)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('dusuns', 'nama')->ignore($dusun->id),
            ],
        ]);

        $dusun->update([
            'nama' => trim($validated['nama']),
        ]);

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Dusun berhasil diperbarui.');
    }

    public function destroyDusun(Dusun $dusun)
    {
        if ($dusun->rws()->exists()) {
            return redirect()
                ->route('wilayah.index')
                ->with('error', 'Dusun tidak bisa dihapus karena masih memiliki RW.');
        }

        $dusun->delete();

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Dusun berhasil dihapus.');
    }

    // =========================
    // RW
    // =========================

    public function storeRw(Request $request)
    {
        $validated = $request->validate([
            'dusun_id' => [
                'required',
                'exists:dusuns,id',
            ],

            'nomor' => [
                'required',
                'string',
                'max:3',
                'regex:/^[0-9]+$/',
            ],
        ]);

        $nomor = str_pad(
            (int) $validated['nomor'],
            2,
            '0',
            STR_PAD_LEFT
        );

        $exists = Rw::where('dusun_id', $validated['dusun_id'])
            ->where('nomor', $nomor)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('wilayah.index')
                ->with('error', "RW {$nomor} sudah ada di dusun tersebut.");
        }

        Rw::create([
            'dusun_id' => $validated['dusun_id'],
            'nomor' => $nomor,
        ]);

        return redirect()
            ->route('wilayah.index')
            ->with('success', "RW {$nomor} berhasil ditambahkan.");
    }

    public function updateRw(Request $request, Rw $rw)
    {
        $validated = $request->validate([
            'nomor' => [
                'required',
                'string',
                'max:3',
                'regex:/^[0-9]+$/',
            ],
        ]);

        $nomor = str_pad(
            (int) $validated['nomor'],
            2,
            '0',
            STR_PAD_LEFT
        );

        $exists = Rw::where('dusun_id', $rw->dusun_id)
            ->where('nomor', $nomor)
            ->where('id', '!=', $rw->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('wilayah.index')
                ->with('error', "RW {$nomor} sudah ada di dusun tersebut.");
        }

        $rw->update([
            'nomor' => $nomor,
        ]);

        return redirect()
            ->route('wilayah.index')
            ->with('success', "RW {$nomor} berhasil diperbarui.");
    }

    public function destroyRw(Rw $rw)
    {
        if ($rw->rts()->exists()) {
            return redirect()
                ->route('wilayah.index')
                ->with('error', 'RW tidak bisa dihapus karena masih memiliki RT.');
        }

        $nomor = $rw->nomor;

        $rw->delete();

        return redirect()
            ->route('wilayah.index')
            ->with('success', "RW {$nomor} berhasil dihapus.");
    }

    // =========================
    // RT
    // =========================

    public function storeRt(Request $request)
    {
        $validated = $request->validate([
            'rw_id' => [
                'required',
                'exists:rws,id',
            ],

            'nomor' => [
                'required',
                'string',
                'max:3',
                'regex:/^[0-9]+$/',
            ],
        ]);

        $nomor = str_pad(
            (int) $validated['nomor'],
            2,
            '0',
            STR_PAD_LEFT
        );

        $exists = Rt::where('rw_id', $validated['rw_id'])
            ->where('nomor', $nomor)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('wilayah.index')
                ->with('error', "RT {$nomor} sudah ada di RW tersebut.");
        }

        Rt::create([
            'rw_id' => $validated['rw_id'],
            'nomor' => $nomor,
        ]);

        return redirect()
            ->route('wilayah.index')
            ->with('success', "RT {$nomor} berhasil ditambahkan.");
    }

    public function updateRt(Request $request, Rt $rt)
    {
        $validated = $request->validate([
            'nomor' => [
                'required',
                'string',
                'max:3',
                'regex:/^[0-9]+$/',
            ],
        ]);

        $nomor = str_pad(
            (int) $validated['nomor'],
            2,
            '0',
            STR_PAD_LEFT
        );

        $exists = Rt::where('rw_id', $rt->rw_id)
            ->where('nomor', $nomor)
            ->where('id', '!=', $rt->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('wilayah.index')
                ->with('error', "RT {$nomor} sudah ada di RW tersebut.");
        }

        $rt->update([
            'nomor' => $nomor,
        ]);

        return redirect()
            ->route('wilayah.index')
            ->with('success', "RT {$nomor} berhasil diperbarui.");
    }

    public function destroyRt(Rt $rt)
    {
        if ($rt->kartuKeluargas()->exists()) {
            return redirect()
                ->route('wilayah.index')
                ->with(
                    'error',
                    'RT tidak bisa dihapus karena masih digunakan oleh data Kartu Keluarga.'
                );
        }

        $nomor = $rt->nomor;

        $rt->delete();

        return redirect()
            ->route('wilayah.index')
            ->with('success', "RT {$nomor} berhasil dihapus.");
    }
}