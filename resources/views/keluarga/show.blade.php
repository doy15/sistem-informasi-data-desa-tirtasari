@extends('layouts.app')

@section('title', 'Detail Kartu Keluarga')

@section('page-title', 'Detail Kartu Keluarga')

@section('content')

@php
    $rt = $kartuKeluarga->rt;
    $rw = $rt?->rw;
    $dusun = $rw?->dusun;

    $noKk = $kartuKeluarga->no_kk;

    $noKkMasked = $noKk
        ? substr($noKk, 0, 4) . '********' . substr($noKk, -4)
        : '-';

    $kepala = $kartuKeluarga->penduduks
        ->firstWhere('status_hubungan_keluarga', 'KEPALA KELUARGA');
@endphp


<div class="page-header">

    <div>
        <h1>Detail Kartu Keluarga</h1>
        <p>Informasi Kartu Keluarga Desa Tirtasari</p>
    </div>

    <a
        href="{{ route('keluarga.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

</div>


{{-- Informasi KK --}}
<div class="table-card" style="margin-bottom:20px;">

    <div class="card-header">
        <h3>Informasi Kartu Keluarga</h3>
    </div>

    <div class="detail-grid">

        <div class="detail-item">
            <span>Nomor KK</span>
            <strong>{{ $noKkMasked }}</strong>
        </div>

        <div class="detail-item">
            <span>Kepala Keluarga</span>
            <strong>
                {{ $kepala?->nama_lengkap ?? '-' }}
            </strong>
        </div>

        <div class="detail-item detail-full">
            <span>Alamat</span>
            <strong>
                {{ $kartuKeluarga->alamat ?? '-' }}
            </strong>
        </div>

        <div class="detail-item">
            <span>RT</span>
            <strong>
                {{ $rt?->nomor ?? '-' }}
            </strong>
        </div>

        <div class="detail-item">
            <span>RW</span>
            <strong>
                {{ $rw?->nomor ?? '-' }}
            </strong>
        </div>

        <div class="detail-item">
            <span>Dusun</span>
            <strong>
                {{ $dusun?->nama ?? '-' }}
            </strong>
        </div>

        <div class="detail-item">
            <span>Jumlah Anggota</span>
            <strong>
                {{ $kartuKeluarga->penduduks->count() }} orang
            </strong>
        </div>

    </div>

</div>


{{-- Anggota keluarga --}}
<div class="table-card">

    <div class="card-header">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:10px;
        ">

            <h3>Anggota Keluarga</h3>

            <span style="
                font-size:13px;
                color:#666;
            ">
                {{ $kartuKeluarga->penduduks->count() }} anggota
            </span>

        </div>

    </div>


    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Hubungan</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Aksi</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($kartuKeluarga->penduduks as $index => $penduduk)

                @php
                    $nik = $penduduk->nik;

                    $nikMasked = $nik
                        ? substr($nik, 0, 4) . '********' . substr($nik, -4)
                        : '-';
                @endphp

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $nikMasked }}
                    </td>

                    <td>
                        <strong>
                            {{ $penduduk->nama_lengkap }}
                        </strong>
                    </td>

                    <td>
                        {{ $penduduk->status_hubungan_keluarga ?? '-' }}
                    </td>

                    <td>
                        {{ $penduduk->jenis_kelamin ?? '-' }}
                    </td>

                    <td>
                        {{ $penduduk->tanggal_lahir?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td>

                        <a
                            href="{{ route('penduduk.show', $penduduk->id) }}"
                            class="btn"
                            style="
                                padding:7px 12px;
                                font-size:13px;
                            "
                        >
                            Detail
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">

                        <div class="empty">

                            <div style="
                                font-size:40px;
                                margin-bottom:10px;
                            ">
                                👥
                            </div>

                            <strong>
                                Belum ada anggota keluarga
                            </strong>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


<style>

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
    }

    .detail-item {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
    }

    .detail-item:nth-child(odd) {
        border-right: 1px solid #eee;
    }

    .detail-item span {
        display: block;
        font-size: 13px;
        color: #777;
        margin-bottom: 6px;
    }

    .detail-item strong {
        font-size: 15px;
        color: #222;
    }

    .detail-full {
        grid-column: 1 / -1;
        border-right: none !important;
    }

    .card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
    }

    .card-header h3 {
        margin: 0;
        font-size: 17px;
    }

    .btn-secondary {
        background: #f1f3f5;
        color: #333;
    }

    @media (max-width: 700px) {

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-item:nth-child(odd) {
            border-right: none;
        }

        .detail-full {
            grid-column: auto;
        }

    }

</style>

@endsection