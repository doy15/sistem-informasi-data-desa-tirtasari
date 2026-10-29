@extends('layouts.app')

@section('title', 'Statistik Desa - Desa Tirtasari')
@section('page-title', 'Statistik Desa')

@section('content')

@php
    $persenLakiLaki = $totalPenduduk > 0
        ? round(($totalLakiLaki / $totalPenduduk) * 100, 1)
        : 0;

    $persenPerempuan = $totalPenduduk > 0
        ? round(($totalPerempuan / $totalPenduduk) * 100, 1)
        : 0;
@endphp

<div class="page-header statistik-page-header">
    <div>
        <h1>Statistik Desa</h1>
        <p>Ringkasan data kependudukan Desa Tirtasari.</p>
    </div>

    <button type="button" class="btn" onclick="window.print()">
        🖨️ Cetak Statistik
    </button>
</div>

{{-- RINGKASAN UTAMA --}}
<div class="cards statistik-cards">
    <div class="card">
        <div class="card-label">Total Penduduk</div>
        <div class="card-value">{{ number_format($totalPenduduk, 0, ',', '.') }}</div>
        <div class="card-desc">Jiwa</div>
    </div>

    <div class="card">
        <div class="card-label">Laki-laki</div>
        <div class="card-value">{{ number_format($totalLakiLaki, 0, ',', '.') }}</div>
        <div class="card-desc">{{ $persenLakiLaki }}% dari penduduk</div>
    </div>

    <div class="card">
        <div class="card-label">Perempuan</div>
        <div class="card-value">{{ number_format($totalPerempuan, 0, ',', '.') }}</div>
        <div class="card-desc">{{ $persenPerempuan }}% dari penduduk</div>
    </div>

    <div class="card">
        <div class="card-label">Kartu Keluarga</div>
        <div class="card-value">{{ number_format($totalKK, 0, ',', '.') }}</div>
        <div class="card-desc">KK terdaftar</div>
    </div>
</div>

{{-- JENIS KELAMIN & STATUS PERKAWINAN --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-header">
            <h3>Jenis Kelamin</h3>
            <p>Komposisi penduduk berdasarkan jenis kelamin.</p>
        </div>

        <div class="stat-content">
            <div class="stat-row">
                <div class="stat-label">
                    <span>Laki-laki</span>
                    <strong>{{ number_format($totalLakiLaki, 0, ',', '.') }} jiwa</strong>
                </div>

                <div class="progress">
                    <div
                        class="progress-bar progress-laki"
                        style="width: {{ $persenLakiLaki }}%;"
                    ></div>
                </div>

                <small>{{ $persenLakiLaki }}%</small>
            </div>

            <div class="stat-row">
                <div class="stat-label">
                    <span>Perempuan</span>
                    <strong>{{ number_format($totalPerempuan, 0, ',', '.') }} jiwa</strong>
                </div>

                <div class="progress">
                    <div
                        class="progress-bar progress-perempuan"
                        style="width: {{ $persenPerempuan }}%;"
                    ></div>
                </div>

                <small>{{ $persenPerempuan }}%</small>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <h3>Status Perkawinan</h3>
            <p>Jumlah penduduk berdasarkan status perkawinan.</p>
        </div>

        <div class="stat-list">
            @forelse ($statistikPernikahan as $item)
                <div class="stat-list-item">
                    <span>{{ $item->kategori }}</span>
                    <strong>{{ number_format($item->total, 0, ',', '.') }}</strong>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada data status perkawinan.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- PENDIDIKAN & AGAMA --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-header">
            <h3>Pendidikan Terakhir</h3>
            <p>Distribusi pendidikan penduduk.</p>
        </div>

        <div class="stat-list">
            @forelse ($statistikPendidikan as $item)
                <div class="stat-list-item">
                    <span>{{ $item->kategori }}</span>
                    <strong>{{ number_format($item->total, 0, ',', '.') }}</strong>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada data pendidikan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <h3>Agama</h3>
            <p>Komposisi agama penduduk.</p>
        </div>

        <div class="stat-list">
            @forelse ($statistikAgama as $item)
                <div class="stat-list-item">
                    <span>{{ $item->kategori }}</span>
                    <strong>{{ number_format($item->total, 0, ',', '.') }}</strong>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada data agama.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- PEKERJAAN --}}
<div class="table-card statistik-table-card">
    <div class="stat-card-header">
        <h3>Jenis Pekerjaan</h3>
        <p>Distribusi penduduk berdasarkan pekerjaan.</p>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Jumlah Penduduk</th>
                    <th>Persentase</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($statistikPekerjaan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>
                            {{ $totalPenduduk > 0
                                ? round(($item->total / $totalPenduduk) * 100, 1)
                                : 0 }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div>📊</div>
                                <h3>Belum ada data pekerjaan</h3>
                                <p>Data akan muncul setelah informasi pekerjaan penduduk tersedia.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- WILAYAH --}}
<div class="table-card statistik-table-card">
    <div class="stat-card-header">
        <h3>Statistik Wilayah</h3>
        <p>Jumlah penduduk dan kartu keluarga berdasarkan wilayah administrasi.</p>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Dusun</th>
                    <th>RW</th>
                    <th>RT</th>
                    <th>Penduduk</th>
                    <th>KK</th>
                </tr>
            </thead>

            <tbody>
                @php $adaWilayah = false; @endphp

                @foreach ($dusunList as $dusun)
                    @foreach ($dusun->rws as $rw)
                        @foreach ($rw->rts as $rt)
                            @php
                                $jumlahKKWilayah = $rt->kartuKeluargas->count();
                                $jumlahPendudukWilayah = $rt->kartuKeluargas
                                    ->sum(fn ($kk) => $kk->penduduks->count());

                                $adaWilayah = true;
                            @endphp

                            <tr>
                                <td>{{ $dusun->nama }}</td>
                                <td>{{ $rw->nomor }}</td>
                                <td>{{ $rt->nomor }}</td>
                                <td>{{ number_format($jumlahPendudukWilayah, 0, ',', '.') }}</td>
                                <td>{{ number_format($jumlahKKWilayah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach

                @unless ($adaWilayah)
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div>📍</div>
                                <h3>Belum ada data wilayah</h3>
                                <p>Data wilayah administrasi akan ditampilkan di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endunless
            </tbody>
        </table>
    </div>
</div>

<style>
    /*
     * Menggunakan variabel dari layouts.app:
     * --surface, --surface-soft, --text, --muted,
     * --border, --hover, --shadow, --brand.
     */

    .statistik-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .statistik-page-header h1 {
        color: var(--text);
    }

    .statistik-page-header p {
        color: var(--muted);
    }

    .statistik-cards {
        margin-bottom: 24px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card,
    .statistik-table-card {
        min-width: 0;
        color: var(--text);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius, 16px);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .stat-card-header {
        padding: 20px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
    }

    .stat-card-header h3 {
        margin: 0 0 6px;
        color: var(--text);
        font-size: 16px;
        font-weight: 700;
        line-height: 1.5;
    }

    .stat-card-header p {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .stat-content {
        padding: 20px;
    }

    .stat-row {
        margin-bottom: 22px;
    }

    .stat-row:last-child {
        margin-bottom: 0;
    }

    .stat-label {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 9px;
        color: var(--text);
        font-size: 13px;
    }

    .stat-label span {
        min-width: 0;
    }

    .stat-label strong {
        color: var(--text);
        font-weight: 700;
        white-space: nowrap;
    }

    .progress {
        height: 9px;
        background: var(--surface-soft);
        border: 1px solid var(--border);
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        max-width: 100%;
        border-radius: 999px;
        transition: width .3s ease;
    }

    .progress-laki {
        background: #3b82f6;
    }

    .progress-perempuan {
        background: #d946a8;
    }

    .stat-row small {
        display: block;
        margin-top: 7px;
        color: var(--muted);
        font-size: 12px;
        text-align: right;
    }

    .stat-list {
        padding: 4px 20px;
        background: var(--surface);
    }

    .stat-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 14px 0;
        color: var(--text);
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }

    .stat-list-item:last-child {
        border-bottom: none;
    }

    .stat-list-item span {
        min-width: 0;
        overflow-wrap: anywhere;
    }

    .stat-list-item strong {
        flex-shrink: 0;
        color: var(--text);
        font-size: 14px;
        font-weight: 700;
        white-space: nowrap;
    }

    .empty-state {
        padding: 30px 20px;
        color: var(--text);
        text-align: center;
    }

    .empty-state div {
        margin-bottom: 10px;
        font-size: 30px;
    }

    .empty-state h3 {
        margin: 0 0 7px;
        color: var(--text);
        font-size: 15px;
        font-weight: 700;
    }

    .empty-state p {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .statistik-table-card {
        margin-bottom: 24px;
    }

    .statistik-table-card .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .statistik-table-card table {
        width: 100%;
        min-width: 560px;
        margin: 0;
        border-collapse: collapse;
        color: var(--text);
        background: var(--surface);
    }

    .statistik-table-card thead {
        background: var(--surface-soft);
    }

    .statistik-table-card th {
        padding: 14px 16px;
        color: var(--muted);
        background: var(--surface-soft);
        border-bottom: 1px solid var(--border);
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
    }

    .statistik-table-card td {
        padding: 14px 16px;
        color: var(--text);
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        font-size: 13px;
        vertical-align: middle;
    }

    .statistik-table-card tbody tr:last-child td {
        border-bottom: none;
    }

    .statistik-table-card tbody tr:hover td {
        background: var(--hover);
    }

    .statistik-table-card td .empty-state {
        background: transparent;
    }

    @media (max-width: 900px) {
        .stat-grid {
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .statistik-page-header {
            align-items: flex-start;
        }

        .stat-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .stat-card-header,
        .stat-content {
            padding: 16px;
        }

        .stat-list {
            padding-right: 16px;
            padding-left: 16px;
        }

        .statistik-table-card .stat-card-header {
            padding: 16px;
        }
    }

    @media (max-width: 480px) {
        .statistik-page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .statistik-page-header .btn {
            width: 100%;
            justify-content: center;
        }

        .stat-label {
            font-size: 12px;
        }

        .statistik-table-card th,
        .statistik-table-card td {
            padding: 12px;
        }
    }

    @media print {
        .statistik-page-header .btn,
        .sidebar,
        .topbar,
        nav {
            display: none !important;
        }

        .stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stat-card,
        .table-card,
        .statistik-table-card,
        .card {
            break-inside: avoid;
            box-shadow: none !important;
        }

        .statistik-table-card .table-wrapper {
            overflow: visible;
        }

        .statistik-table-card table {
            min-width: 0;
        }

        .statistik-table-card th,
        .statistik-table-card td {
            color: #111827 !important;
            background: #ffffff !important;
            border-color: #d1d5db !important;
        }
    }
</style>

@endsection