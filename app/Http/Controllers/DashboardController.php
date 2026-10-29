<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Penduduk;
use App\Models\KartuKeluarga;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenduduk = Penduduk::count();

        $totalLakiLaki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();

        $totalPerempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();

        $totalKk = KartuKeluarga::count();

        $totalDusun = Dusun::count();

        $totalRw = Rw::count();

        $totalRt = Rt::count();

        // Rekap penduduk berdasarkan dusun
        $pendudukPerDusun = Dusun::with([
            'rws.rts.kartuKeluargas.penduduks'
        ])
            ->orderBy('nama')
            ->get()
            ->map(function ($dusun) {

                $jumlah = 0;

                foreach ($dusun->rws as $rw) {
                    foreach ($rw->rts as $rt) {
                        foreach ($rt->kartuKeluargas as $kk) {
                            $jumlah += $kk->penduduks->count();
                        }
                    }
                }

                return [
                    'nama' => $dusun->nama,
                    'jumlah' => $jumlah,
                ];
            });

        return view('dashboard', [
            'totalPenduduk' => $totalPenduduk,
            'totalLakiLaki' => $totalLakiLaki,
            'totalPerempuan' => $totalPerempuan,
            'totalKk' => $totalKk,
            'totalDusun' => $totalDusun,
            'totalRw' => $totalRw,
            'totalRt' => $totalRt,
            'pendudukPerDusun' => $pendudukPerDusun,
        ]);
    }
}