@extends('layouts.app')

@section('title', 'Data Kartu Keluarga - Desa Tirtasari')

@section('page-title', 'Data Kartu Keluarga')

@section('content')

@php
    $totalKK = $kartuKeluargas->count();

    $totalAnggota = $kartuKeluargas->sum(function ($kk) {
        return $kk->penduduks->count();
    });

    $totalDusun = $kartuKeluargas
        ->map(fn ($kk) => $kk->rt?->rw?->dusun?->id)
        ->filter()
        ->unique()
        ->count();
@endphp


{{-- HEADER --}}
<div class="page-header">

    <div>
        <h1>Data Kartu Keluarga</h1>
        <p>Kelola data Kartu Keluarga Desa Tirtasari.</p>
    </div>

    <a
        href="{{ route('keluarga.create') }}"
        class="btn-primary"
    >
        + Tambah Kartu Keluarga
    </a>

</div>


{{-- NOTIFIKASI --}}
@if (session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if (session('error'))

    <div class="alert alert-error">
        {{ session('error') }}
    </div>

@endif


{{-- STATISTIK --}}
<div class="cards" style="margin-bottom:25px;">

    <div class="card">

        <div class="label">
            Total KK
        </div>

        <div class="number">
            {{ $totalKK }}
        </div>

    </div>


    <div class="card">

        <div class="label">
            Total Anggota
        </div>

        <div class="number">
            {{ $totalAnggota }}
        </div>

    </div>


    <div class="card">

        <div class="label">
            Jumlah Dusun
        </div>

        <div class="number">
            {{ $totalDusun }}
        </div>

    </div>

</div>


{{-- PENCARIAN --}}
<div
    class="table-card"
    style="padding:20px; margin-bottom:20px;"
>

    <form
        method="GET"
        action="{{ route('keluarga.index') }}"
    >

        <div style="
            display:grid;
            grid-template-columns:1fr auto;
            gap:10px;
        ">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari Nomor KK atau alamat..."
                style="
                    width:100%;
                    padding:11px 14px;
                    border:1px solid #d1d5db;
                    border-radius:8px;
                    outline:none;
                    box-sizing:border-box;
                "
            >

            <button
                type="submit"
                class="btn"
            >
                Cari
            </button>

        </div>

    </form>

</div>


{{-- TABEL --}}
<div class="table-card">

    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>No. KK</th>

                <th>Kepala Keluarga</th>

                <th>Jumlah Anggota</th>

                <th>Alamat</th>

                <th>RT/RW</th>

                <th>Dusun</th>

                <th>Aksi</th>

            </tr>

        </thead>


        <tbody>

            @forelse ($kartuKeluargas as $index => $kk)

                @php

                    $kepala = $kk->penduduks
                        ->firstWhere(
                            'status_hubungan_keluarga',
                            'KEPALA KELUARGA'
                        );

                    $noKk = $kk->no_kk;

                    $noKkMasked = $noKk
                        ? substr($noKk, 0, 4)
                            . '********'
                            . substr($noKk, -4)
                        : '-';

                @endphp


                <tr>

                    {{-- NO --}}
                    <td>
                        {{ $index + 1 }}
                    </td>


                    {{-- NO KK --}}
                    <td>
                        <strong>
                            {{ $noKkMasked }}
                        </strong>
                    </td>


                    {{-- KEPALA KELUARGA --}}
                    <td>

                        <strong>
                            {{ $kepala?->nama_lengkap ?? '-' }}
                        </strong>

                    </td>


                    {{-- JUMLAH ANGGOTA --}}
                    <td>

                        {{ $kk->penduduks->count() }}
                        orang

                    </td>


                    {{-- ALAMAT --}}
                    <td>

                        {{ $kk->alamat ?? '-' }}

                    </td>


                    {{-- RT RW --}}
                    <td>

                        @if ($kk->rt)

                            RT {{ $kk->rt->nomor }}

                            /

                            RW {{ $kk->rt->rw->nomor }}

                        @else

                            -

                        @endif

                    </td>


                    {{-- DUSUN --}}
                    <td>

                        {{ $kk->rt?->rw?->dusun?->nama ?? '-' }}

                    </td>


                    {{-- AKSI --}}
                    <td>

                        <a
                            href="{{ route('keluarga.show', $kk->id) }}"
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

                    <td colspan="8">

                        <div class="empty">

                            <div style="
                                font-size:40px;
                                margin-bottom:10px;
                            ">
                                🏠
                            </div>


                            <strong>
                                Belum ada data Kartu Keluarga
                            </strong>


                            <p style="margin-top:5px;">

                                Data KK akan muncul di sini
                                setelah dataset dimasukkan
                                ke sistem.

                            </p>


                            <a
                                href="{{ route('keluarga.create') }}"
                                class="btn-primary"
                                style="
                                    display:inline-block;
                                    margin-top:15px;
                                "
                            >
                                + Tambah Kartu Keluarga
                            </a>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


<style>

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.page-header h1 {
    margin: 0 0 6px;
}

.page-header p {
    margin: 0;
    color: #64748b;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 16px;
    border-radius: 8px;
    background: #16a34a;
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background: #15803d;
}

.alert {
    margin-bottom: 20px;
    padding: 13px 16px;
    border-radius: 8px;
}

.alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

@media (max-width: 700px) {

    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>

@endsection