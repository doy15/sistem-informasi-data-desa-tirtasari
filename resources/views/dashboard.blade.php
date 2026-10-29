@extends('layouts.app')

@section('title', 'Dashboard - Desa Tirtasari')

@section('page-title', 'Dashboard')

@section('content')

<div class="welcome">
    <h1>Selamat Datang 👋</h1>

    <p>
        Sistem Informasi Administrasi Desa Tirtasari
    </p>
</div>

<div class="cards">

    <div class="card">
        <div class="label">Total Penduduk</div>
        <div class="number">{{ $totalPenduduk }}</div>
    </div>

    <div class="card">
        <div class="label">Total Keluarga</div>
        <div class="number">{{ $totalKk }}</div>
    </div>

    <div class="card">
        <div class="label">Total Laki-laki</div>
        <div class="number">{{ $totalLakiLaki }}</div>
    </div>

    <div class="card">
        <div class="label">Total Perempuan</div>
        <div class="number">{{ $totalPerempuan }}</div>
    </div>

</div>

<div class="cards" style="margin-top: 20px;">

    <div class="card">
        <div class="label">Total Dusun</div>
        <div class="number">{{ $totalDusun }}</div>
    </div>

    <div class="card">
        <div class="label">Total RW</div>
        <div class="number">{{ $totalRw }}</div>
    </div>

    <div class="card">
        <div class="label">Total RT</div>
        <div class="number">{{ $totalRt }}</div>
    </div>

</div>

<div class="card" style="margin-top: 20px;">

    <div class="label" style="font-size: 18px; margin-bottom: 15px;">
        Penduduk per Dusun
    </div>

    @forelse($pendudukPerDusun as $dusun)

        <div style="
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        ">
            <span>{{ $dusun['nama'] }}</span>

            <strong>
                {{ $dusun['jumlah'] }} Penduduk
            </strong>
        </div>

    @empty

        <div>
            Belum ada data penduduk.
        </div>

    @endforelse

</div>

@endsection