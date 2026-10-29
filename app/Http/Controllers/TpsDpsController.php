<?php

namespace App\Http\Controllers;

use App\Models\Pemilihan;
use App\Models\Penduduk;
use App\Models\Tps;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TpsDpsController extends Controller
{
    public function show(Pemilihan $pemilihan, Tps $tps)
    {
        abort_unless(
            (int) $tps->pemilihan_id === (int) $pemilihan->id,
            404
        );

        $tanggalPemilihan = Carbon::parse(
            $pemilihan->tanggal_pemilihan
        )->startOfDay();

        $tps->load('rts.rw.dusun');

        $rtIds = $tps->rts->pluck('id');

        $penduduks = Penduduk::with('kartuKeluarga.rt.rw.dusun')
            ->whereNotNull('tanggal_lahir')
            ->whereDate(
                'tanggal_lahir',
                '<=',
                $tanggalPemilihan->toDateString()
            )
            ->whereHas('kartuKeluarga', function ($kk) use ($rtIds) {
                $kk->whereIn('rt_id', $rtIds);
            })
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($penduduk) use ($tanggalPemilihan) {
                $tanggalLahir = Carbon::parse($penduduk->tanggal_lahir);

                $penduduk->umur_pada_pemilihan =
                    (int) $tanggalLahir->diffInYears($tanggalPemilihan);

                return $penduduk;
            })
            ->filter(fn ($penduduk) =>
                $penduduk->umur_pada_pemilihan >= 17
            )
            ->values();

        $jumlahLakiLaki = $penduduks->filter(
            fn ($p) =>
                strtoupper(trim((string) $p->jenis_kelamin)) === 'LAKI-LAKI'
        )->count();

        $jumlahPerempuan = $penduduks->filter(
            fn ($p) =>
                strtoupper(trim((string) $p->jenis_kelamin)) === 'PEREMPUAN'
        )->count();

        return view('data-pemilih.tps', [
            'pemilihan' => $pemilihan,
            'tps' => $tps,
            'penduduks' => $penduduks,
            'jumlahLakiLaki' => $jumlahLakiLaki,
            'jumlahPerempuan' => $jumlahPerempuan,
        ]);
    }

    public function exportCsv(Pemilihan $pemilihan, Tps $tps)
    {
        abort_unless(
            (int) $tps->pemilihan_id === (int) $pemilihan->id,
            404
        );

        $response = app()->call([$this, 'showDataForExport'], [
            'pemilihan' => $pemilihan,
            'tps' => $tps,
        ]);

        return $response;
    }

    public function showDataForExport(Pemilihan $pemilihan, Tps $tps)
    {
        abort_unless(
            (int) $tps->pemilihan_id === (int) $pemilihan->id,
            404
        );

        $tanggalPemilihan = Carbon::parse(
            $pemilihan->tanggal_pemilihan
        )->startOfDay();

        $rtIds = $tps->rts()->pluck('rts.id');

        $penduduks = Penduduk::with('kartuKeluarga.rt')
            ->whereNotNull('tanggal_lahir')
            ->whereDate('tanggal_lahir', '<=', $tanggalPemilihan->toDateString())
            ->whereHas('kartuKeluarga', fn ($kk) =>
                $kk->whereIn('rt_id', $rtIds)
            )
            ->orderBy('nama_lengkap')
            ->get()
            ->filter(fn ($p) =>
                Carbon::parse($p->tanggal_lahir)->diffInYears($tanggalPemilihan) >= 17
            )
            ->values();

        return response()->streamDownload(function () use (
            $penduduks,
            $pemilihan,
            $tps
        ) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Pemilihan',
                'Tanggal Pemilihan',
                'TPS',
                'No.',
                'NIK',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'Umur',
                'RT',
                'Nomor KK',
                'Alamat',
            ]);

            foreach ($penduduks as $i => $p) {
                $kk = $p->kartuKeluarga;
                $rt = $kk?->rt;

                fputcsv($handle, [
                    $pemilihan->nama,
                    $pemilihan->tanggal_pemilihan?->format('Y-m-d'),
                    $tps->nomor,
                    $i + 1,
                    $p->nik,
                    $p->nama_lengkap,
                    $p->jenis_kelamin,
                    $p->tanggal_lahir?->format('Y-m-d'),
                    Carbon::parse($p->tanggal_lahir)->diffInYears(
                        Carbon::parse($pemilihan->tanggal_pemilihan)
                    ),
                    $rt?->nomor ?? '-',
                    $kk?->no_kk ?? '-',
                    $kk?->alamat ?? '-',
                ]);
            }

            fclose($handle);
        }, 'DPS-TPS-'.$tps->nomor.'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Pemilihan $pemilihan, Tps $tps)
    {
        abort_unless(
            (int) $tps->pemilihan_id === (int) $pemilihan->id,
            404
        );

        $response = $this->show($pemilihan, $tps);

        $data = $response->getData();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'data-pemilih.tps-pdf',
            [
                'pemilihan' => $data['pemilihan'],
                'tps' => $data['tps'],
                'penduduks' => $data['penduduks'],
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->download('DPS-TPS-'.$tps->nomor.'.pdf');
    }
}
