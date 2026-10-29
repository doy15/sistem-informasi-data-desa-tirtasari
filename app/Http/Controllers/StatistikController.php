<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Dusun;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $totalPenduduk = Penduduk::count();
        $totalKK = KartuKeluarga::count();

        $totalLakiLaki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();

        $statistikPernikahan = Penduduk::selectRaw(
            "COALESCE(NULLIF(status_perkawinan, ''), 'Belum diisi') AS kategori, COUNT(*) AS total"
        )
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $statistikPendidikan = Penduduk::selectRaw(
            "COALESCE(NULLIF(pendidikan_akhir, ''), 'Belum diisi') AS kategori, COUNT(*) AS total"
        )
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $statistikAgama = Penduduk::selectRaw(
            "COALESCE(NULLIF(agama, ''), 'Belum diisi') AS kategori, COUNT(*) AS total"
        )
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $statistikPekerjaan = Penduduk::selectRaw(
            "COALESCE(NULLIF(jenis_pekerjaan, ''), 'Belum diisi') AS kategori, COUNT(*) AS total"
        )
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $dusunList = Dusun::with([
            'rws.rts.kartuKeluargas.penduduks'
        ])->get();

        return view('statistik.index', compact(
            'totalPenduduk',
            'totalKK',
            'totalLakiLaki',
            'totalPerempuan',
            'statistikPernikahan',
            'statistikPendidikan',
            'statistikAgama',
            'statistikPekerjaan',
            'dusunList'
        ));
    }
}
