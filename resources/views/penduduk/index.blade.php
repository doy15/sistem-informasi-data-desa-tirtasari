
@extends('layouts.app')

@section('title', 'Data Penduduk - Desa Tirtasari')
@section('page-title', 'Data Penduduk')

@section('content')

<style>
    .penduduk-table-wrap {
        overflow-x: auto;
    }

    .penduduk-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: collapse;
    }

    .penduduk-table th,
    .penduduk-table td {
        padding: 10px;
        border: 1px solid #d1d5db;
        text-align: left;
        vertical-align: top;
    }

    .penduduk-table th {
        background: #f3f4f6;
        color: #111827;
        font-size: 12px;
        white-space: nowrap;
    }

    .penduduk-table td {
        font-size: 13px;
    }

    .penduduk-table .center {
        text-align: center;
    }

    .penduduk-toolbar {
        display: grid;
        grid-template-columns: minmax(200px, 1fr) 200px auto;
        gap: 10px;
    }

    .penduduk-toolbar input,
    .penduduk-toolbar select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
    }

    .penduduk-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .penduduk-summary-card {
        padding: 18px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .penduduk-summary-label {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .penduduk-summary-number {
        font-size: 26px;
        font-weight: bold;
        color: #166534;
    }

    .penduduk-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .penduduk-actions .btn {
        padding: 7px 10px;
        font-size: 12px;
    }

    @media (max-width: 700px) {
        .penduduk-toolbar {
            grid-template-columns: 1fr;
        }

        .penduduk-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media print {
        .sidebar,
        .topbar,
        .penduduk-search,
        .penduduk-actions,
        .no-print,
        .penduduk-summary,
        .page-header .btn {
            display: none !important;
        }

        .main,
        .content,
        .table-card {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .penduduk-table-wrap {
            overflow: visible;
        }

        .penduduk-table {
            width: 100%;
            min-width: 0;
        }

        .penduduk-table th,
        .penduduk-table td {
            padding: 4px;
            font-size: 8px;
        }

        @page {
            size: landscape;
            margin: 8mm;
        }
    }
</style>

@php
    $totalPenduduk = $penduduks->count();

    $lakiLaki = $penduduks->filter(function ($p) {
        return strtoupper(trim((string) $p->jenis_kelamin)) === 'LAKI-LAKI';
    })->count();

    $perempuan = $penduduks->filter(function ($p) {
        return strtoupper(trim((string) $p->jenis_kelamin)) === 'PEREMPUAN';
    })->count();

    $totalKK = $penduduks->pluck('kartuKeluarga')
        ->filter()
        ->unique('id')
        ->count();
@endphp

<div class="page-header">
    <div>
        <h1>Data Penduduk</h1>
        <p>Data penduduk Desa Tirtasari dalam format tabel.</p>
    </div>

    <div class="no-print">
        <button type="button" class="btn" onclick="window.print()">
            Cetak
        </button>

        <a href="{{ route('penduduk.create') }}" class="btn">
            + Tambah Penduduk
        </a>
    </div>
</div>

@if (session('success'))
    <div style="padding:12px 16px;margin-bottom:18px;background:#dcfce7;color:#166534;border-radius:8px;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="padding:12px 16px;margin-bottom:18px;background:#fee2e2;color:#991b1b;border-radius:8px;">
        <ul style="padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="penduduk-summary">
    <div class="penduduk-summary-card">
        <div class="penduduk-summary-label">Total Penduduk</div>
        <div class="penduduk-summary-number">{{ $totalPenduduk }}</div>
    </div>

    <div class="penduduk-summary-card">
        <div class="penduduk-summary-label">Laki-laki</div>
        <div class="penduduk-summary-number">{{ $lakiLaki }}</div>
    </div>

    <div class="penduduk-summary-card">
        <div class="penduduk-summary-label">Perempuan</div>
        <div class="penduduk-summary-number">{{ $perempuan }}</div>
    </div>

    <div class="penduduk-summary-card">
        <div class="penduduk-summary-label">Jumlah KK</div>
        <div class="penduduk-summary-number">{{ $totalKK }}</div>
    </div>
</div>

<div class="table-card penduduk-search"
     style="padding:18px;margin-bottom:20px;">

    <form method="GET"
          action="{{ route('penduduk.index') }}"
          class="penduduk-toolbar">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama, NIK, No. KK, atau alamat..."
        >

        <select name="jenis_kelamin">
            <option value="">Semua Jenis Kelamin</option>

            <option value="LAKI-LAKI"
                {{ request('jenis_kelamin') === 'LAKI-LAKI' ? 'selected' : '' }}>
                Laki-laki
            </option>

            <option value="PEREMPUAN"
                {{ request('jenis_kelamin') === 'PEREMPUAN' ? 'selected' : '' }}>
                Perempuan
            </option>
        </select>

        <button type="submit" class="btn">Cari</button>
    </form>
</div>

<div class="table-card">
    <div class="penduduk-table-wrap">
        <table class="penduduk-table">
            <thead>
                <tr>
                    <th>NO URUT</th>
                    <th>NAMA LENGKAP</th>
                    <th>JENIS KELAMIN</th>
                    <th>TEMPAT, TGL. LAHIR</th>
                    <th>STATUS (K/TK/D)</th>
                    <th>NOMOR NIK/KTP</th>
                    <th>DUSUN/JALAN</th>
                    <th>RT</th>
		    <th>RW</th>
		    <th>KET.</th>
                    <th class="no-print">AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($penduduks as $index => $penduduk)
                    @php
                        $statusRaw = strtolower(trim(
                            (string) $penduduk->status_perkawinan
                        ));

                        $status = '-';

                        if (in_array($statusRaw, [
                            'kawin', 'menikah', 'k'
                        ])) {
                            $status = 'K';
                        } elseif (in_array($statusRaw, [
                            'belum kawin',
                            'belum menikah',
                            'tidak kawin',
                            'tk'
                        ])) {
                            $status = 'TK';
                        } elseif (in_array($statusRaw, [
                            'cerai hidup',
                            'cerai mati',
                            'duda',
                            'janda',
                            'd'
                        ])) {
                            $status = 'D';
                        }

                        $kk = $penduduk->kartuKeluarga;
                        $rt = $kk?->rt;
                        $rw = $rt?->rw;
                        $dusun = $rw?->dusun?->nama;

                        $alamat = collect([
                            $dusun,
                            $kk?->alamat
                        ])->filter()->unique()->implode(' / ');

                        $tanggalLahir = $penduduk->tanggal_lahir;

                        if ($tanggalLahir) {
                            try {
                                $tanggalLahir = \Illuminate\Support\Carbon::parse(
                                    $tanggalLahir
                                )->format('d-m-Y');
                            } catch (\Throwable $e) {
                                // Tampilkan nilai asli jika format tanggal tidak dikenali.
                            }
                        }

                        $lahir = collect([
                            $penduduk->tempat_lahir,
                            $tanggalLahir
                        ])->filter()->implode(', ');

                        $jenisKelamin = trim(
                            (string) $penduduk->jenis_kelamin
                        );

                        if (strtoupper($jenisKelamin) === 'LAKI-LAKI') {
                            $jenisKelamin = 'Laki-laki';
                        } elseif (strtoupper($jenisKelamin) === 'PEREMPUAN') {
                            $jenisKelamin = 'Perempuan';
                        }
                    @endphp

                    <tr>
                        <td class="center">{{ $index + 1 }}</td>

                        <td>
                            <strong>{{ $penduduk->nama_lengkap ?: '-' }}</strong>
                        </td>

                        <td>{{ $jenisKelamin ?: '-' }}</td>

                        <td>{{ $lahir ?: '-' }}</td>

                        <td class="center">{{ $status }}</td>

                        <td>{{ $penduduk->nik ?: '-' }}</td>

                        <td>{{ $alamat ?: '-' }}</td>

                        <td class="center">{{ $rt?->nomor ?? '-' }}</td>

			<td class="center">{{ $rw?->nomor ?? '-' }}</td>

			<td>{{ $penduduk->hb ?: '-' }}</td>

                        <td class="no-print">
                            <div class="penduduk-actions">
                                <a
                                    href="{{ url('/penduduk/' . $penduduk->id . '/edit') }}"
                                    class="btn"
                                >Edit</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" style="text-align:center;padding:30px;">
                            Belum ada data penduduk yang cocok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
