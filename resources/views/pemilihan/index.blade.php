@extends('layouts.app')

@section('title', 'Data Pemilihan')
@section('page-title', 'Pemilihan & TPS')

@section('content')
<div class="page-header">
    <div>
        <h1>Data Pemilihan</h1>
        <p>Pengaturan pemilihan dan alokasi TPS Desa Tirtasari.</p>
    </div>

    <a href="{{ route('pemilihan.create') }}" class="btn">
        + Tambah Pemilihan
    </a>
</div>

@if (session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px;margin-bottom:20px;border-radius:8px">
        {{ session('success') }}
    </div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Nama Pemilihan</th>
                <th>Tanggal</th>
                <th>Kapasitas per TPS</th>
                <th>Jumlah TPS</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pemilihan as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tanggal_pemilihan?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ number_format($item->kapasitas_tps, 0, ',', '.') }} pemilih</td>
                    <td>{{ $item->tps_count }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>
                        <a href="{{ route('pemilihan.show', $item->id) }}">Atur TPS</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">
                        Belum ada data pemilihan. Klik Tambah Pemilihan untuk memulai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
