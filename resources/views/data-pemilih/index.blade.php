@extends('layouts.app')

@section('content')
<div style="padding:24px;">

    <h1>Data Pemilih / DPS</h1>

    <form method="GET" action="{{ route('data-pemilih.index') }}"
          style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px;">

        <label style="display:flex;flex-direction:column;gap:5px;">
            <strong>Pilih Pemilihan</strong>
            <select name="pemilihan_id" style="padding:9px;min-width:230px;">
                @foreach ($daftarPemilihan as $item)
                    <option value="{{ $item->id }}"
                        {{ $pemilihan?->id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                        ({{ $item->tanggal_pemilihan?->format('d-m-Y') }})
                    </option>
                @endforeach
            </select>
        </label>

        <input type="text" name="search" value="{{ $search }}"
               placeholder="Cari nama, NIK, nomor KK, alamat..."
               style="padding:9px;min-width:230px;">

        <select name="dusun" style="padding:9px;">
            <option value="">Semua Dusun</option>
            @foreach ($dusuns as $dusun)
                <option value="{{ $dusun->id }}"
                    {{ $dusunFilter == $dusun->id ? 'selected' : '' }}>
                    {{ $dusun->nama }}
                </option>
            @endforeach
        </select>

        <select name="rw" style="padding:9px;">
            <option value="">Semua RW</option>
            @foreach ($rws as $rw)
                <option value="{{ $rw->id }}"
                    {{ $rwFilter == $rw->id ? 'selected' : '' }}>
                    RW {{ $rw->nomor }} ({{ $rw->dusun?->nama ?? '-' }})
                </option>
            @endforeach
        </select>

        <select name="rt" style="padding:9px;">
            <option value="">Semua RT</option>
            @foreach ($rts as $rt)
                <option value="{{ $rt->id }}"
                    {{ $rtFilter == $rt->id ? 'selected' : '' }}>
                    RT {{ $rt->nomor }} (RW {{ $rt->rw?->nomor ?? '-' }})
                </option>
            @endforeach
        </select>

        <button type="submit" style="padding:9px 14px;">Cari / Filter</button>
        <a href="{{ route('data-pemilih.index', ['pemilihan_id' => $pemilihan?->id]) }}"
           style="padding:9px 14px;">Reset Filter</a>
    </form>

    <p>
        Pemilihan:
        <strong>{{ $pemilihan?->nama ?? 'Belum ada pemilihan' }}</strong>
        <br>
        Tanggal pemilihan:
        <strong>{{ $tanggalPemilihan->format('d-m-Y') }}</strong>
        <br>
        Jumlah calon pemilih sesuai filter:
        <strong>{{ $jumlahCalonPemilih }}</strong>
    </p>

    <h2 style="margin-top:24px;">Rekap Calon Pemilih per TPS</h2>

    <div style="overflow-x:auto;margin-bottom:22px;">
        <table border="1" cellpadding="9" cellspacing="0"
               style="border-collapse:collapse;width:100%;">
            <thead>
                <tr>
                    <th>TPS</th>
                    <th>Laki-laki</th>
                    <th>Perempuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekapTps as $rekap)
                    <tr>
                        <td>
    		<a href="{{ route('data-pemilih.tps.show', [
        		'pemilihan' => $pemilihan->id,
        		'tps' => $rekap['id'],
    			]) }}">
        		TPS {{ $rekap['nomor'] }}
    			</a>
			</td>
                        <td>{{ $rekap['laki_laki'] }}</td>
                        <td>{{ $rekap['perempuan'] }}</td>
                        <td>{{ $rekap['total'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Belum ada TPS untuk pemilihan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex;gap:10px;margin-bottom:18px;">
        <a href="{{ route('data-pemilih.index', array_merge(
                request()->query(), ['export' => 'csv']
            )) }}"
           style="padding:9px 14px;background:#198754;color:white;text-decoration:none;">
            Ekspor CSV / Excel
        </a>

        <button type="button" onclick="window.print()" style="padding:9px 14px;">
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
                    <th>TPS</th>
                    <th>Dusun</th>
                    <th>RW</th>
                    <th>RT</th>
                    <th>Nomor KK</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($calonPemilih as $i => $penduduk)
                    @php
                        $kk = $penduduk->kartuKeluarga;
                        $rt = $kk?->rt;
                        $rw = $rt?->rw;
                        $dusun = $rw?->dusun;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $penduduk->nik }}</td>
                        <td>{{ $penduduk->nama_lengkap }}</td>
                        <td>{{ $penduduk->jenis_kelamin ?? '-' }}</td>
                        <td>{{ $penduduk->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td>
                        <td>{{ $penduduk->umur_pada_pemilihan }} tahun</td>
                        <td>
                            {{ $penduduk->nomor_tps !== null
                                ? 'TPS '.$penduduk->nomor_tps
                                : 'Belum dialokasikan' }}
                        </td>
                        <td>{{ $dusun?->nama ?? '-' }}</td>
                        <td>{{ $rw?->nomor ?? '-' }}</td>
                        <td>{{ $rt?->nomor ?? '-' }}</td>
                        <td>{{ $kk?->no_kk ?? '-' }}</td>
                        <td>{{ $kk?->alamat ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align:center;">
                            Tidak ada calon pemilih yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p style="margin-top:16px;font-size:13px;">
        Catatan: daftar ini merupakan calon pemilih berdasarkan umur dan data
        penduduk yang tersedia. Daftar ini belum menjadi daftar pemilih resmi.
        Pemilih yang RT-nya belum dialokasikan akan ditandai
        "Belum dialokasikan".
    </p>
</div>

<style>
@media print {
    nav, aside, header, form, button, a {
        display:none !important;
    }

    body {
        font-size:11px;
    }

    table {
        width:100%;
    }

    th, td {
        padding:4px;
    }
}
</style>
@endsection
