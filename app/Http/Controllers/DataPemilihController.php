<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Pemilihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataPemilihController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar pemilihan.
        $daftarPemilihan = Pemilihan::with('tps')
            ->orderByDesc('tanggal_pemilihan')
            ->get();

        // Gunakan pemilihan yang dipilih atau pemilihan terbaru.
        $pemilihanId = $request->input(
            'pemilihan_id',
            $daftarPemilihan->first()?->id
        );

        $pemilihan = $daftarPemilihan->firstWhere(
            'id',
            (int) $pemilihanId
        );

        // Cegah ID pemilihan yang tidak tersedia.
        if (!$pemilihan) {
            $pemilihan = $daftarPemilihan->first();
        }

        $tanggalPemilihan = $pemilihan?->tanggal_pemilihan
            ? Carbon::parse($pemilihan->tanggal_pemilihan)->startOfDay()
            : Carbon::today();

        // Peta RT ke TPS untuk pemilihan yang dipilih.
        $rtKeTps = [];

        if ($pemilihan) {
            $pemilihan->load('tps.rts');

            foreach ($pemilihan->tps as $tps) {
                foreach ($tps->rts as $rt) {
                    $rtKeTps[$rt->id] = $tps->nomor;
                }
            }
        }

        // Ambil penduduk dan hubungan wilayahnya.
        $query = Penduduk::with('kartuKeluarga.rt.rw.dusun')
            ->whereNotNull('tanggal_lahir')
            ->whereDate(
                'tanggal_lahir',
                '<=',
                $tanggalPemilihan->toDateString()
            );

        // Pencarian nama, NIK, nomor KK, atau alamat.
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhereHas('kartuKeluarga', function ($kk) use ($search) {
                        $kk->where('no_kk', 'like', "%{$search}%")
                            ->orWhere('alamat', 'like', "%{$search}%");
                    });
            });
        }

        // Hitung umur pada tanggal pemilihan.
        $calonPemilih = $query
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($penduduk) use ($tanggalPemilihan, $rtKeTps) {
                $tanggalLahir = Carbon::parse($penduduk->tanggal_lahir);

                $penduduk->umur_pada_pemilihan =
                    (int) $tanggalLahir->diffInYears($tanggalPemilihan);

                $rtId = $penduduk->kartuKeluarga?->rt?->id;

                $penduduk->nomor_tps = $rtId !== null
                    ? ($rtKeTps[$rtId] ?? null)
                    : null;

                return $penduduk;
            })
            ->filter(fn ($penduduk) =>
                $penduduk->umur_pada_pemilihan >= 17
            )
            ->values();

        // Filter wilayah.
        $dusunFilter = $request->input('dusun', '');
        $rwFilter = $request->input('rw', '');
        $rtFilter = $request->input('rt', '');

        $calonPemilih = $calonPemilih
            ->filter(function ($penduduk) use (
                $dusunFilter,
                $rwFilter,
                $rtFilter
            ) {
                $kk = $penduduk->kartuKeluarga;
                $rt = $kk?->rt;
                $rw = $rt?->rw;
                $dusun = $rw?->dusun;

                if (
                    $dusunFilter !== ''
                    && (string) ($dusun?->id ?? '') !== (string) $dusunFilter
                ) {
                    return false;
                }

                if (
                    $rwFilter !== ''
                    && (string) ($rw?->id ?? '') !== (string) $rwFilter
                ) {
                    return false;
                }

                if (
                    $rtFilter !== ''
                    && (string) ($rt?->id ?? '') !== (string) $rtFilter
                ) {
                    return false;
                }

                return true;
            })
            ->values();

        // Rekap TPS berdasarkan calon pemilih yang memenuhi filter.
        $rekapTps = collect();

        if ($pemilihan) {
            $rekapTps = $pemilihan->tps
                ->sortBy('nomor')
                ->map(function ($tps) use ($calonPemilih) {
                    $anggota = $calonPemilih->filter(
                        fn ($penduduk) =>
                            (string) $penduduk->nomor_tps
                            === (string) $tps->nomor
                    );

                    return [
    			'id' => $tps->id,
    			'nomor' => $tps->nomor,
    			'total' => $anggota->count(),
                        'laki_laki' => $anggota->filter(
                            fn ($p) =>
                                strtoupper(trim((string) $p->jenis_kelamin))
                                === 'LAKI-LAKI'
                        )->count(),
                        'perempuan' => $anggota->filter(
                            fn ($p) =>
                                strtoupper(trim((string) $p->jenis_kelamin))
                                === 'PEREMPUAN'
                        )->count(),
                    ];
                })
                ->values();
        }

        // Dropdown wilayah.
        $dusuns = Dusun::orderBy('nama')->get();

        $rws = Rw::with('dusun')
            ->orderBy('nomor')
            ->get();

        $rts = Rt::with('rw.dusun')
            ->orderBy('nomor')
            ->get();

        // Ekspor hasil yang sedang ditampilkan ke CSV.
        if ($request->query('export') === 'csv') {
            return response()->streamDownload(
                function () use ($calonPemilih, $pemilihan) {
                    $handle = fopen('php://output', 'w');

                    // BOM agar karakter UTF-8 terbaca Excel.
                    fwrite($handle, "\xEF\xBB\xBF");

                    fputcsv($handle, [
                        'Pemilihan',
                        'Tanggal Pemilihan',
                        'No.',
                        'NIK',
                        'Nama Lengkap',
                        'Jenis Kelamin',
                        'Tanggal Lahir',
                        'Umur Saat Pemilihan',
                        'TPS',
                        'Dusun',
                        'RW',
                        'RT',
                        'Nomor KK',
                        'Alamat',
                    ]);

                    foreach ($calonPemilih as $index => $penduduk) {
                        $kk = $penduduk->kartuKeluarga;
                        $rt = $kk?->rt;
                        $rw = $rt?->rw;
                        $dusun = $rw?->dusun;

                        fputcsv($handle, [
                            $pemilihan?->nama ?? '-',
                            $pemilihan?->tanggal_pemilihan?->format('Y-m-d') ?? '-',
                            $index + 1,
                            $penduduk->nik,
                            $penduduk->nama_lengkap,
                            $penduduk->jenis_kelamin,
                            $penduduk->tanggal_lahir?->format('Y-m-d'),
                            $penduduk->umur_pada_pemilihan,
                            $penduduk->nomor_tps ?? 'Belum dialokasikan',
                            $dusun?->nama ?? '-',
                            $rw?->nomor ?? '-',
                            $rt?->nomor ?? '-',
                            $kk?->no_kk ?? '-',
                            $kk?->alamat ?? '-',
                        ]);
                    }

                    fclose($handle);
                },
                'daftar-calon-pemilih.csv',
                ['Content-Type' => 'text/csv; charset=UTF-8']
            );
        }

        return view('data-pemilih.index', [
            'calonPemilih' => $calonPemilih,
            'tanggalPemilihan' => $tanggalPemilihan,
            'pemilihan' => $pemilihan,
            'daftarPemilihan' => $daftarPemilihan,
            'rekapTps' => $rekapTps,
            'jumlahCalonPemilih' => $calonPemilih->count(),
            'search' => $request->input('search', ''),
            'dusuns' => $dusuns,
            'rws' => $rws,
            'rts' => $rts,
            'dusunFilter' => $dusunFilter,
            'rwFilter' => $rwFilter,
            'rtFilter' => $rtFilter,
        ]);
    }
}
