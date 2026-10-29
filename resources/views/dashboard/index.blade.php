@extends('layouts.app')

@section('content')

<div class="welcome">
    <h2>Selamat Datang di Sistem Informasi Desa Tirtasari</h2>
    <p>
        Kelola data administrasi dan pelayanan Desa Tirtasari
        dalam satu sistem.
    </p>
</div>

<div class="cards">

    <div class="card">
        <div class="card-label">Total Penduduk</div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-label">Total Keluarga</div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-label">Wilayah / Dusun</div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-label">Surat Hari Ini</div>
        <div class="card-value">0</div>
    </div>

</div>

<div class="section">
    <h3>Aktivitas Terbaru</h3>
    <p>
        Belum ada aktivitas. Data akan muncul setelah sistem mulai digunakan.
    </p>
</div>

@endsection