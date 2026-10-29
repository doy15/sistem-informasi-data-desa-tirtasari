@extends('layouts.app')

@section('title', 'Detail Pemilihan')
@section('page-title', 'Pengaturan TPS')

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $pemilihan->nama }}</h1>
        <p>
            Tanggal pemilihan:
            {{ \Carbon\Carbon::parse($pemilihan->tanggal_pemilihan)->format('d-m-Y') }}
        </p>
        <p>
            Kapasitas per TPS:
            {{ number_format($pemilihan->kapasitas_tps) }} pemilih
        </p>
    </div>

    <a href="{{ route('pemilihan.index') }}" class="btn">Kembali</a>
</div>

@if (session('success'))
    <div class="table-card" style="padding:15px; margin-bottom:20px; color:green;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="table-card" style="padding:15px; margin-bottom:20px; color:#b91c1c;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="table-card" style="padding:24px; margin-bottom:24px;">
    <h2>Tambah TPS</h2>

    <form method="POST" action="{{ route('pemilihan.tps.store', $pemilihan) }}">
        @csrf

        <label for="nomor">Nomor TPS</label>
        <input
            type="number"
            id="nomor"
            name="nomor"
            min="1"
            required
            value="{{ old('nomor', ($pemilihan->tps->max('nomor') ?? 0) + 1) }}"
            style="display:block; padding:10px; margin:8px 0 16px; max-width:300px; width:100%;"
        >

        <button type="submit" class="btn">Tambah TPS</button>
    </form>
</div>


<h2>Daftar TPS dan Alokasi RT</h2>

@forelse ($pemilihan->tps as $tps)
    <div class="table-card" style="padding:24px; margin-bottom:20px; border-radius:12px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <div>
                <h3 style="margin:0 0 6px;">TPS {{ $tps->nomor }}</h3>
                <p style="margin:0; color:#64748b;">
                    {{ $tps->rts->count() }} RT dialokasikan
                </p>
            </div>

            <span style="padding:6px 12px; border-radius:20px; background:#dcfce7; color:#166534; font-size:13px;">
                {{ $tps->rts->count() }} RT
            </span>
        </div>

        <div style="margin-top:20px;">
            @forelse ($tps->rts->sortBy('nomor')->groupBy('rw_id') as $daftarRt)
                <div style="margin-bottom:16px;">
                    <strong>
                        @if ($daftarRt->first()->rw)
                            RW {{ str_pad($daftarRt->first()->rw->nomor, 2, '0', STR_PAD_LEFT) }}
                        @else
                            RW belum ditentukan
                        @endif
                    </strong>

                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:8px;">
                        @foreach ($daftarRt->sortBy('nomor') as $rt)
                            <span style="padding:7px 12px; border:1px solid #cbd5e1; border-radius:8px;">
                                RT {{ str_pad($rt->nomor, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <p style="color:#64748b;">Belum ada RT yang dialokasikan ke TPS ini.</p>
            @endforelse
        </div>

        <details style="margin-top:20px; border-top:1px solid #e5e7eb; padding-top:16px;">
            <summary style="cursor:pointer; font-weight:600;">
                Edit Alokasi RT
            </summary>

            <form
                method="POST"
                action="{{ route('pemilihan.tps.rt.update', [$pemilihan, $tps]) }}"
                style="margin-top:16px;"
            >
                @csrf

                <p style="color:#64748b;">
                    Centang RT yang ingin dimasukkan ke TPS ini. RT yang sudah dialokasikan ke TPS lain tidak bisa dipilih.
                </p>

                @php
                    $kelompokRw = $rts->groupBy(function ($rt) {
                        return $rt->rw?->id ?? 0;
                    });
                @endphp

                @foreach ($kelompokRw as $rwId => $daftarRt)
                    <div style="margin:16px 0; padding:14px; border:1px solid #e5e7eb; border-radius:10px;">
                        <h4 style="margin:0 0 12px;">
                            @if ($daftarRt->first()->rw)
                                RW {{ str_pad($daftarRt->first()->rw->nomor, 2, '0', STR_PAD_LEFT) }}
                            @else
                                RW belum ditentukan
                            @endif
                        </h4>

                        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px;">
                            @foreach ($daftarRt->sortBy('nomor') as $rt)
                                @php
                                    $dipilih = $tps->rts->contains('id', $rt->id);
                                    $dipakaiLain = in_array($rt->id, $rtTerpakai) && !$dipilih;
                                @endphp

                                <label style="display:flex; gap:8px; align-items:center; {{ $dipakaiLain ? 'opacity:0.5' : '' }}">
                                    <input
                                        type="checkbox"
                                        name="rt_ids[]"
                                        value="{{ $rt->id }}"
                                        {{ $dipilih ? 'checked' : '' }}
                                        {{ $dipakaiLain ? 'disabled' : '' }}
                                    >

                                    <span>
                                        RT {{ str_pad($rt->nomor, 2, '0', STR_PAD_LEFT) }}

                                        @if ($dipakaiLain)
                                            <small>(TPS lain)</small>
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn">Simpan Perubahan</button>
            </form>
        </details>
    </div>
@empty
    <div class="table-card" style="padding:24px;">
        Belum ada TPS. Silakan tambahkan TPS terlebih dahulu.
    </div>
@endforelse
@endsection
