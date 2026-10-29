
@extends('layouts.app')

@section('title', 'Tambah Pemilihan')
@section('page-title', 'Tambah Pemilihan')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Pemilihan</h1>
        <p>Isi informasi pemilihan dan kapasitas setiap TPS.</p>
    </div>
</div>

<div class="table-card" style="padding:24px; max-width:700px;">
    <form action="{{ route('pemilihan.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:18px;">
            <label for="nama" style="display:block;margin-bottom:8px;">
                Nama Pemilihan
            </label>
            <input
                type="text"
                id="nama"
                name="nama"
                value="{{ old('nama') }}"
                placeholder="Contoh: Pemilihan Kepala Desa"
                required
                style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;"
            >
            @error('nama')
                <p style="color:#dc2626;margin-top:5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:18px;">
            <label for="tanggal_pemilihan" style="display:block;margin-bottom:8px;">
                Tanggal Pemilihan
            </label>
            <input
                type="date"
                id="tanggal_pemilihan"
                name="tanggal_pemilihan"
                value="{{ old('tanggal_pemilihan') }}"
                required
                style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;"
            >
            @error('tanggal_pemilihan')
                <p style="color:#dc2626;margin-top:5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label for="kapasitas_tps" style="display:block;margin-bottom:8px;">
                Kapasitas Pemilih per TPS
            </label>
            <input
                type="number"
                id="kapasitas_tps"
                name="kapasitas_tps"
                value="{{ old('kapasitas_tps', 500) }}"
                min="1"
                required
                style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;"
            >
            @error('kapasitas_tps')
                <p style="color:#dc2626;margin-top:5px;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn">
            Simpan Pemilihan
        </button>

        <a href="{{ route('pemilihan.index') }}"
           style="margin-left:12px;color:#4b5563;text-decoration:none;">
            Batal
        </a>
    </form>
</div>
@endsection
