@extends('layouts.app')

@section('content')
<div style="padding:24px;">
    <p>
        <a href="{{ route('data-pemilih.index', ['pemilihan_id' => $pemilihan->id]) }}">
            &larr; Kembali ke daftar TPS
        </a>
    </p>

    <h1>Daftar Pemilih TPS {{ $tps->nomor }}</h1>
    <p>Pemilihan: <strong>{{ $pemilihan->nama }}</strong></p>
    <p>Tanggal: {{ $pemilihan->tanggal_pemilihan?->format('d-m-Y') }}</p>

    <div style="display:flex;gap:20px;flex-wrap:wrap;margin:20px 0;">
        <div style="border:1px solid #ddd;padding:16px;border-radius:8px;">
            Total pemilih: <strong>{{ $penduduks->count() }}</strong>
        </div>
        <div style="border:1px solid #ddd;padding:16px;border-radius:8px;">
            Laki-laki: <strong>{{ $jumlahLakiLaki }}</strong>
        </div>
        <div style="border:1px solid #ddd;padding:16px;border-radius:8px;">
            Perempuan: <strong>{{ $jumlahPerempuan }}</strong>
        </div>
    </div>

    <h3>RT yang dialokasikan ke TPS ini</h3>
    <p>
        @forelse ($tps->rts->sortBy('nomor') as $rt)
            <span style="display:inline-block;border:1px solid #ddd;border-radius:5px;padding:5px 9px;margin:3px;">
                RT {{ $rt->nomor }}
                (RW {{ $rt->rw?->nomor ?? '-' }})
            </span>
        @empty
            Belum ada RT yang dialokasikan.
        @endforelse
    </p>

    <div style="display:flex;gap:10px;flex-wrap:wrap;margin:20px 0;">
        <a href="{{ route('data-pemilih.tps.csv', [$pemilihan->id, $tps->id]) }}"
           style="padding:10px 14px;background:#198754;color:white;text-decoration:none;border-radius:5px;">
            Ekspor Excel / CSV
        </a>

        <a href="{{ route('data-pemilih.tps.pdf', [$pemilihan->id, $tps->id]) }}"
           style="padding:10px 14px;background:#b42318;color:white;text-decoration:none;border-radius:5px;">
            Unduh PDF
        </a>

        <button onclick="window.print()" style="padding:10px 14px;">
            Cetak
        </button>
    </div>

    <div style="overflow-x:auto;">
        <table border="1" cellpadding="8" cellspacing="0"
               style="border-collapse:collapse;width:100%;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Umur</th>
                    <th>RT</th>
                    <th>RW</th>
                    <th>Dusun</th>
                    <th>Nomor KK</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penduduks as $i => $p)
                    @php
                        $kk = $p->kartuKeluarga;
                        $rt = $kk?->rt;
                        $rw = $rt?->rw;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->jenis_kelamin ?? '-' }}</td>
                        <td>{{ $p->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td>
                        <td>{{ $p->umur_pada_pemilihan }} tahun</td>
                        <td>{{ $rt?->nomor ?? '-' }}</td>
                        <td>{{ $rw?->nomor ?? '-' }}</td>
                        <td>{{ $rw?->dusun?->nama ?? '-' }}</td>
                        <td>{{ $kk?->no_kk ?? '-' }}</td>
                        <td>{{ $kk?->alamat ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" style="text-align:center;">
                            Belum ada calon pemilih yang memenuhi kriteria di TPS ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@media print {
    nav, aside, header, button, a {
        display:none !important;
    }
    body { font-size:10px; }
    th, td { padding:4px; }
}
</style>
@endsection
