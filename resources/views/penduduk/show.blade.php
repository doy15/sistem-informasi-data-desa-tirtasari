@extends('layouts.app')

@section('title', 'Detail Penduduk')

@section('content')

@php
    $kk = $penduduk->kartuKeluarga;
    $rt = $kk?->rt;
    $rw = $rt?->rw;
    $dusun = $rw?->dusun;

    $nik = $penduduk->nik;
    $noKk = $kk?->no_kk;

    $nikMasked = $nik
        ? substr($nik, 0, 4) . '********' . substr($nik, -4)
        : '-';

    $kkMasked = $noKk
        ? substr($noKk, 0, 4) . '********' . substr($noKk, -4)
        : '-';
@endphp


<div class="page-header">
    <div>
        <h1>Detail Penduduk</h1>
        <p>Informasi lengkap data penduduk Desa Tirtasari</p>
    </div>

    <div style="display:flex; gap:10px;">
        <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>

        <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-primary">
            Edit Data
        </a>
    </div>
</div>


{{-- Identitas --}}
<div class="table-card" style="margin-bottom:20px;">
    <div class="card-header">
        <h3>Identitas Penduduk</h3>
    </div>

    <div class="detail-grid">

        <div class="detail-item">
            <span>NIK</span>
            <strong>{{ $nikMasked }}</strong>
        </div>

        <div class="detail-item">
            <span>Nama Lengkap</span>
            <strong>{{ $penduduk->nama_lengkap }}</strong>
        </div>

        <div class="detail-item">
            <span>Jenis Kelamin</span>
            <strong>{{ $penduduk->jenis_kelamin ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Tempat Lahir</span>
            <strong>{{ $penduduk->tempat_lahir ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Tanggal Lahir</span>
            <strong>
                {{ $penduduk->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}
            </strong>
        </div>

        <div class="detail-item">
            <span>Golongan Darah</span>
            <strong>{{ $penduduk->golongan_darah ?? '-' }}</strong>
        </div>

    </div>
</div>


{{-- Keluarga --}}
<div class="table-card" style="margin-bottom:20px;">
    <div class="card-header">
        <h3>Data Keluarga</h3>
    </div>

    <div class="detail-grid">

        <div class="detail-item">
            <span>Nomor KK</span>
            <strong>{{ $kkMasked }}</strong>
        </div>

        <div class="detail-item">
            <span>Hubungan Dalam Keluarga</span>
            <strong>
                {{ $penduduk->status_hubungan_keluarga ?? '-' }}
            </strong>
        </div>

    </div>
</div>


{{-- Alamat --}}
<div class="table-card" style="margin-bottom:20px;">
    <div class="card-header">
        <h3>Alamat & Wilayah</h3>
    </div>

    <div class="detail-grid">

        <div class="detail-item detail-full">
            <span>Alamat</span>
            <strong>{{ $kk?->alamat ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>RT</span>
            <strong>{{ $rt?->nomor ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>RW</span>
            <strong>{{ $rw?->nomor ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Dusun</span>
            <strong>{{ $dusun?->nama ?? '-' }}</strong>
        </div>

    </div>
</div>


{{-- Data kependudukan --}}
<div class="table-card" style="margin-bottom:20px;">
    <div class="card-header">
        <h3>Data Kependudukan</h3>
    </div>

    <div class="detail-grid">

        <div class="detail-item">
            <span>Agama</span>
            <strong>{{ $penduduk->agama ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Pendidikan Terakhir</span>
            <strong>{{ $penduduk->pendidikan_akhir ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Jenis Pekerjaan</span>
            <strong>{{ $penduduk->jenis_pekerjaan ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Status Perkawinan</span>
            <strong>{{ $penduduk->status_perkawinan ?? '-' }}</strong>
        </div>

    </div>
</div>


{{-- Orang tua --}}
<div class="table-card">
    <div class="card-header">
        <h3>Data Orang Tua</h3>
    </div>

    <div class="detail-grid">

        <div class="detail-item">
            <span>Nama Ibu</span>
            <strong>{{ $penduduk->nama_ibu ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Nama Ayah</span>
            <strong>{{ $penduduk->nama_ayah ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Nomor Paspor</span>
            <strong>{{ $penduduk->no_paspor ?? '-' }}</strong>
        </div>

        <div class="detail-item">
            <span>Masa Berlaku Paspor</span>
            <strong>
                {{ $penduduk->tanggal_akhir_paspor?->translatedFormat('d F Y') ?? '-' }}
            </strong>
        </div>

        <div class="detail-item">
            <span>HB</span>
            <strong>{{ $penduduk->hb ?? '-' }}</strong>
        </div>

    </div>
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