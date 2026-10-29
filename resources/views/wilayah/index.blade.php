
@extends('layouts.app')

@section('title', 'Wilayah Desa')
@section('page-title', 'Wilayah Desa')

@section('content')

@php
    $totalDusun = $dusuns->count();
    $totalRw = $dusuns->sum(fn ($dusun) => $dusun->rws->count());
    $totalRt = $dusuns->sum(fn ($dusun) =>
        $dusun->rws->sum(fn ($rw) => $rw->rts->count())
    );
@endphp

@if (session('success'))
    <div class="wil-alert success">
        <span>✓</span> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="wil-alert error">
        <span>!</span> {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="wil-alert error">
        <span>!</span> {{ $errors->first() }}
    </div>
@endif

{{-- JUDUL HALAMAN --}}
<div class="wil-page-heading">
    <div>
        <div class="wil-eyebrow">ADMINISTRASI DESA</div>
        <h1>Struktur Wilayah</h1>
        <p>Kelola dusun, RW, dan RT Desa Tirtasari dalam satu tempat.</p>
    </div>

    <button type="button" class="wil-btn primary"
            onclick="wilToggle('form-dusun')">
        <span>＋</span> Tambah Dusun
    </button>
</div>

{{-- RINGKASAN --}}
<div class="wil-stats">
    <div class="wil-stat">
        <div class="wil-stat-icon blue">⌂</div>
        <div>
            <div class="wil-stat-label">Total Dusun</div>
            <div class="wil-stat-number">{{ $totalDusun }}</div>
            <div class="wil-stat-note">Wilayah administratif</div>
        </div>
    </div>

    <div class="wil-stat">
        <div class="wil-stat-icon violet">▦</div>
        <div>
            <div class="wil-stat-label">Total RW</div>
            <div class="wil-stat-number">{{ $totalRw }}</div>
            <div class="wil-stat-note">Rukun warga</div>
        </div>
    </div>

    <div class="wil-stat">
        <div class="wil-stat-icon cyan">⌗</div>
        <div>
            <div class="wil-stat-label">Total RT</div>
            <div class="wil-stat-number">{{ $totalRt }}</div>
            <div class="wil-stat-note">Rukun tetangga</div>
        </div>
    </div>
</div>

{{-- FORM TAMBAH DUSUN --}}
<div id="form-dusun" class="wil-panel wil-create-panel" hidden>
    <div class="wil-panel-heading">
        <div>
            <span class="wil-section-tag">DATA BARU</span>
            <h3>Tambah Dusun</h3>
            <p>Masukkan nama dusun yang akan ditambahkan.</p>
        </div>
        <button type="button" class="wil-close"
                onclick="wilToggle('form-dusun')" aria-label="Tutup">×</button>
    </div>

    <form method="POST" action="{{ route('wilayah.dusun.store') }}">
        @csrf
        <div class="wil-form-grid">
            <div class="wil-field">
                <label for="nama-dusun">Nama Dusun</label>
                <input id="nama-dusun" type="text" name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Dusun Cempaka" required>
            </div>
            <button type="submit" class="wil-btn primary">Simpan Dusun</button>
        </div>
    </form>
</div>

{{-- DAFTAR DUSUN --}}
<div class="wil-list-heading">
    <div>
        <h2>Daftar Wilayah</h2>
        <p>{{ $totalDusun }} dusun · {{ $totalRw }} RW · {{ $totalRt }} RT</p>
    </div>
    <span class="wil-total-badge">{{ $totalDusun }} Dusun</span>
</div>

<div class="wil-dusun-list">
    @forelse ($dusuns as $dusun)
        <section class="wil-panel wil-dusun" id="dusun-{{ $dusun->id }}">

            {{-- HEADER DUSUN --}}
            <div class="wil-dusun-header">
                <div class="wil-dusun-identity">
                    <div class="wil-dusun-icon">⌂</div>
                    <div>
                        <div class="wil-level">TINGKAT DUSUN</div>
                        <h3>{{ $dusun->nama }}</h3>
                        <div class="wil-subline">
                            {{ $dusun->rws->count() }} RW
                            <span>·</span>
                            {{ $dusun->rws->sum(fn ($rw) => $rw->rts->count()) }} RT
                        </div>
                    </div>
                </div>

                <div class="wil-actions">
                    <button type="button" class="wil-btn small primary-outline"
                            onclick="wilToggle('rw-form-{{ $dusun->id }}')">
                        ＋ RW
                    </button>
                    <button type="button" class="wil-btn small neutral"
                            onclick="wilToggle('edit-dusun-{{ $dusun->id }}')">
                        Edit
                    </button>
                    <form method="POST"
                          action="{{ route('wilayah.dusun.destroy', $dusun->id) }}"
                          onsubmit="return confirm('Hapus dusun {{ $dusun->nama }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="wil-btn small danger">Hapus</button>
                    </form>
                </div>
            </div>

            {{-- EDIT DUSUN --}}
            <div id="edit-dusun-{{ $dusun->id }}" class="wil-inline-form" hidden>
                <form method="POST"
                      action="{{ route('wilayah.dusun.update', $dusun->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="wil-inline-title">Ubah nama dusun</div>
                    <div class="wil-inline-row">
                        <input type="text" name="nama" value="{{ $dusun->nama }}"
                               aria-label="Nama dusun" required>
                        <button type="submit" class="wil-btn small primary">Simpan</button>
                        <button type="button" class="wil-btn small neutral"
                                onclick="wilToggle('edit-dusun-{{ $dusun->id }}')">Batal</button>
                    </div>
                </form>
            </div>

            {{-- TAMBAH RW --}}
            <div id="rw-form-{{ $dusun->id }}" class="wil-inline-form" hidden>
                <form method="POST" action="{{ route('wilayah.rw.store') }}">
                    @csrf
                    <input type="hidden" name="dusun_id" value="{{ $dusun->id }}">
                    <div class="wil-inline-title">Tambah RW ke {{ $dusun->nama }}</div>
                    <div class="wil-inline-row">
                        <input type="text" name="nomor" maxlength="3"
                               inputmode="numeric" placeholder="Nomor RW, contoh: 07"
                               aria-label="Nomor RW" required>
                        <button type="submit" class="wil-btn small primary">Tambah RW</button>
                        <button type="button" class="wil-btn small neutral"
                                onclick="wilToggle('rw-form-{{ $dusun->id }}')">Batal</button>
                    </div>
                </form>
            </div>

            {{-- DAFTAR RW --}}
            <div class="wil-rw-list">
                @forelse ($dusun->rws as $rw)
                    <div class="wil-rw" id="rw-{{ $rw->id }}">

                        <div class="wil-rw-header">
                            <div class="wil-rw-identity">
                                <div class="wil-rw-icon">▦</div>
                                <div>
                                    <div class="wil-level">RUKUN WARGA</div>
                                    <strong>RW {{ str_pad($rw->nomor, 2, '0', STR_PAD_LEFT) }}</strong>
                                </div>
                            </div>

                            <div class="wil-actions">
                                <span class="wil-count-pill">
                                    {{ $rw->rts->count() }} RT
                                </span>
                                <button type="button" class="wil-btn small primary-outline"
                                        onclick="wilToggle('rt-form-{{ $rw->id }}')">
                                    ＋ RT
                                </button>
                                <button type="button" class="wil-btn small neutral"
                                        onclick="wilToggle('edit-rw-{{ $rw->id }}')">Edit</button>
                                <form method="POST"
                                      action="{{ route('wilayah.rw.destroy', $rw->id) }}"
                                      onsubmit="return confirm('Hapus RW ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="wil-btn small danger">Hapus</button>
                                </form>
                            </div>
                        </div>

                        {{-- EDIT RW --}}
                        <div id="edit-rw-{{ $rw->id }}" class="wil-inline-form" hidden>
                            <form method="POST"
                                  action="{{ route('wilayah.rw.update', $rw->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="wil-inline-title">Ubah nomor RW</div>
                                <div class="wil-inline-row">
                                    <input type="text" name="nomor" maxlength="3"
                                           inputmode="numeric" value="{{ $rw->nomor }}"
                                           aria-label="Nomor RW" required>
                                    <button type="submit" class="wil-btn small primary">Simpan</button>
                                    <button type="button" class="wil-btn small neutral"
                                            onclick="wilToggle('edit-rw-{{ $rw->id }}')">Batal</button>
                                </div>
                            </form>
                        </div>

                        {{-- TAMBAH RT --}}
                        <div id="rt-form-{{ $rw->id }}" class="wil-inline-form" hidden>
                            <form method="POST" action="{{ route('wilayah.rt.store') }}">
                                @csrf
                                <input type="hidden" name="rw_id" value="{{ $rw->id }}">
                                <div class="wil-inline-title">Tambah RT ke RW {{ str_pad($rw->nomor, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="wil-inline-row">
                                    <input type="text" name="nomor" maxlength="3"
                                           inputmode="numeric" placeholder="Nomor RT, contoh: 14"
                                           aria-label="Nomor RT" required>
                                    <button type="submit" class="wil-btn small primary">Tambah RT</button>
                                    <button type="button" class="wil-btn small neutral"
                                            onclick="wilToggle('rt-form-{{ $rw->id }}')">Batal</button>
                                </div>
                            </form>
                        </div>

                        {{-- DAFTAR RT --}}
                        <div class="wil-rt-list">
                            @forelse ($rw->rts as $rt)
                                <div class="wil-rt">
                                    <span class="wil-rt-icon">⌗</span>
                                    <span class="wil-rt-name">
                                        RT {{ str_pad($rt->nomor, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <div class="wil-rt-actions">
                                        <button type="button" class="wil-text-btn"
                                                onclick="wilToggle('edit-rt-{{ $rt->id }}')">Edit</button>
                                        <form method="POST"
                                              action="{{ route('wilayah.rt.destroy', $rt->id) }}"
                                              onsubmit="return confirm('Hapus RT ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="wil-text-btn danger-text">Hapus</button>
                                        </form>
                                    </div>
                                </div>

                                {{-- EDIT RT --}}
                                <div id="edit-rt-{{ $rt->id }}" class="wil-inline-form" hidden>
                                    <form method="POST"
                                          action="{{ route('wilayah.rt.update', $rt->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="wil-inline-title">Ubah nomor RT</div>
                                        <div class="wil-inline-row">
                                            <input type="text" name="nomor" maxlength="3"
                                                   inputmode="numeric" value="{{ $rt->nomor }}"
                                                   aria-label="Nomor RT" required>
                                            <button type="submit" class="wil-btn small primary">Simpan</button>
                                            <button type="button" class="wil-btn small neutral"
                                                    onclick="wilToggle('edit-rt-{{ $rt->id }}')">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            @empty
                                <div class="wil-empty">Belum ada RT pada RW ini.</div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="wil-empty-block">
                        <div class="wil-empty-icon">▦</div>
                        <strong>Belum ada RW</strong>
                        <p>Tambahkan RW pertama untuk dusun ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    @empty
        <div class="wil-panel wil-no-data">
            <div class="wil-empty-icon">⌖</div>
            <h3>Belum ada data wilayah</h3>
            <p>Mulai dengan menambahkan dusun untuk membangun struktur wilayah Desa Tirtasari.</p>
            <button type="button" class="wil-btn primary"
                    onclick="wilToggle('form-dusun')">＋ Tambah Dusun</button>
        </div>
    @endforelse
</div>

<style>
    /* Semua warna mengikuti tema dari layouts.app */
    .wil-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid var(--border);
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.6;
    }
    .wil-alert.success {
        background: #e9f9ef;
        color: #166534;
        border-color: #bbf7d0;
    }
    .wil-alert.error {
        background: #fff0f0;
        color: #991b1b;
        border-color: #fecaca;
    }
    html[data-theme="dark"] .wil-alert.success {
        background: #123426;
        color: #a7f3c1;
        border-color: #24563c;
    }
    html[data-theme="dark"] .wil-alert.error {
        background: #3b2028;
        color: #fecaca;
        border-color: #66313b;
    }

    .wil-page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }
    .wil-eyebrow, .wil-level, .wil-section-tag {
        color: var(--muted);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.15px;
    }
    .wil-eyebrow { margin-bottom: 7px; color: var(--brand); }
    .wil-page-heading h1 {
        color: var(--text);
        font-size: clamp(23px, 3vw, 29px);
        letter-spacing: -.7px;
        line-height: 1.2;
    }
    .wil-page-heading p, .wil-panel-heading p {
        margin-top: 7px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .wil-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 34px;
        padding: 8px 12px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        text-decoration: none;
        cursor: pointer;
        transition: transform .18s, background .18s, border-color .18s, box-shadow .18s;
    }
    .wil-btn:hover { transform: translateY(-1px); }
    .wil-btn.primary {
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        box-shadow: 0 4px 12px rgba(37,99,235,.18);
    }
    .wil-btn.primary:hover {
        box-shadow: 0 7px 17px rgba(37,99,235,.25);
    }
    .wil-btn.primary-outline {
        color: var(--brand);
        background: var(--hover);
        border-color: #c9dcff;
    }
    html[data-theme="dark"] .wil-btn.primary-outline {
        background: #1b3151;
        border-color: #304b70;
        color: #a9caff;
    }
    .wil-btn.neutral {
        color: var(--text);
        background: var(--surface);
        border-color: var(--border);
    }
    .wil-btn.neutral:hover { background: var(--hover); }
    .wil-btn.danger {
        color: #dc4545;
        background: #fff1f1;
        border-color: #ffd8d8;
    }
    html[data-theme="dark"] .wil-btn.danger {
        color: #ffb4b4;
        background: #39212a;
        border-color: #5b3039;
    }
    .wil-btn.small { min-height: 31px; padding: 7px 10px; font-size: 11px; }

    .wil-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }
    .wil-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
        padding: 20px;
        border: 1px solid var(--border);
        border-radius: 15px;
        background: var(--surface);
        box-shadow: var(--shadow);
        transition: transform .2s, border-color .2s;
    }
    .wil-stat:hover { transform: translateY(-2px); border-color: #9bbcff; }
    .wil-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 13px;
        font-size: 22px;
        font-weight: 700;
    }
    .wil-stat-icon.blue { color: #2563eb; background: #eaf1ff; }
    .wil-stat-icon.violet { color: #7c3aed; background: #f1eaff; }
    .wil-stat-icon.cyan { color: #087eaa; background: #e1f6ff; }
    html[data-theme="dark"] .wil-stat-icon.blue { color: #a9caff; background: #20385e; }
    html[data-theme="dark"] .wil-stat-icon.violet { color: #d2b8ff; background: #382853; }
    html[data-theme="dark"] .wil-stat-icon.cyan { color: #a5e7ff; background: #17394b; }
    .wil-stat-label { color: var(--muted); font-size: 12px; font-weight: 600; }
    .wil-stat-number {
        margin-top: 5px;
        color: var(--text);
        font-size: 29px;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -.7px;
    }
    .wil-stat-note { margin-top: 6px; color: var(--muted); font-size: 11px; }

    .wil-panel {
        min-width: 0;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: var(--surface);
        box-shadow: var(--shadow);
    }
    .wil-create-panel { padding: 22px; margin-bottom: 24px; }
    .wil-panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 20px;
    }
    .wil-panel-heading h3 { margin-top: 5px; color: var(--text); font-size: 17px; }
    .wil-close {
        width: 34px;
        height: 34px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: var(--surface-soft);
        color: var(--muted);
        font-size: 23px;
        cursor: pointer;
    }
    .wil-close:hover { color: var(--text); background: var(--hover); }
    .wil-form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: end;
        gap: 14px;
    }
    .wil-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--text);
        font-size: 12px;
        font-weight: 700;
    }
    .wil-field input, .wil-inline-row input {
        width: 100%;
        min-width: 0;
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        outline: none;
        background: var(--surface-soft);
        color: var(--text);
        font-family: inherit;
        font-size: 13px;
        transition: border-color .18s, box-shadow .18s;
    }
    .wil-field input:focus, .wil-inline-row input:focus {
        border-color: #6094ff;
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .wil-field input::placeholder, .wil-inline-row input::placeholder {
        color: var(--muted);
        opacity: .8;
    }

    .wil-list-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 15px;
    }
    .wil-list-heading h2 { color: var(--text); font-size: 17px; }
    .wil-list-heading p { margin-top: 5px; color: var(--muted); font-size: 12px; }
    .wil-total-badge {
        padding: 7px 11px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--surface);
        color: var(--muted);
        font-size: 11px;
        font-weight: 750;
    }
    .wil-dusun-list { display: grid; gap: 17px; }
    .wil-dusun { overflow: hidden; }

    .wil-dusun-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 21px;
        background: linear-gradient(110deg, var(--surface), var(--surface-soft));
        border-bottom: 1px solid var(--border);
    }
    .wil-dusun-identity, .wil-rw-identity {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }
    .wil-dusun-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border: 1px solid #cbdcff;
        border-radius: 14px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 25px;
    }
    html[data-theme="dark"] .wil-dusun-icon {
        background: #20385e;
        border-color: #304b70;
        color: #a9caff;
    }
    .wil-level { margin-bottom: 5px; }
    .wil-dusun-header h3 { color: var(--text); font-size: 18px; overflow-wrap: anywhere; }
    .wil-subline {
        display: flex;
        gap: 7px;
        margin-top: 6px;
        color: var(--muted);
        font-size: 11px;
    }
    .wil-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
        flex-wrap: wrap;
    }
    .wil-actions form, .wil-rt-actions form { display: inline-flex; margin: 0; }
    .wil-rw-list { padding: 5px 21px 17px; }
    .wil-rw { padding: 17px 0; border-bottom: 1px solid var(--border); }
    .wil-rw:last-child { border-bottom: 0; padding-bottom: 3px; }
    .wil-rw-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }
    .wil-rw-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        border: 1px solid var(--border);
        border-radius: 11px;
        background: var(--surface-soft);
        color: var(--brand);
        font-size: 18px;
    }
    .wil-rw-header strong { color: var(--text); font-size: 14px; }
    .wil-count-pill {
        padding: 6px 9px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--surface-soft);
        color: var(--muted);
        font-size: 11px;
        font-weight: 700;
    }
    .wil-rt-list {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin: 13px 0 0 51px;
    }
    .wil-rt {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 8px 10px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--surface-soft);
        transition: border-color .18s, background .18s;
    }
    .wil-rt:hover { border-color: #a9c5ff; }
    .wil-rt-icon { color: var(--brand); font-size: 15px; }
    .wil-rt-name { color: var(--text); font-size: 12px; font-weight: 750; }
    .wil-rt-actions { display: inline-flex; align-items: center; gap: 7px; }
    .wil-text-btn {
        padding: 2px 0;
        border: 0;
        background: transparent;
        color: var(--brand);
        font-family: inherit;
        font-size: 11px;
        font-weight: 650;
        cursor: pointer;
    }
    .wil-text-btn:hover { text-decoration: underline; }
    .wil-text-btn.danger-text { color: #dc4545; }
    .wil-inline-form {
        padding: 15px 21px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-soft);
    }
    .wil-inline-title { margin-bottom: 9px; color: var(--muted); font-size: 11px; font-weight: 750; }
    .wil-inline-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .wil-inline-row input { width: min(100%, 250px); min-height: 36px; padding: 8px 10px; }
    .wil-empty {
        padding: 13px 0 3px;
        color: var(--muted);
        font-size: 12px;
    }
    .wil-empty-block {
        padding: 22px 15px;
        border: 1px dashed var(--border);
        border-radius: 12px;
        text-align: center;
    }
    .wil-empty-icon { margin-bottom: 8px; color: var(--brand); font-size: 29px; }
    .wil-empty-block strong { color: var(--text); font-size: 13px; }
    .wil-empty-block p { margin: 5px 0 12px; color: var(--muted); font-size: 12px; }
    .wil-no-data { padding: 48px 22px; text-align: center; }
    .wil-no-data .wil-empty-icon { font-size: 42px; }
    .wil-no-data h3 { color: var(--text); font-size: 18px; }
    .wil-no-data p {
        max-width: 450px;
        margin: 8px auto 18px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }

    [hidden] { display: none !important; }

    @media (max-width: 900px) {
        .wil-stats { gap: 12px; }
        .wil-stat { padding: 16px; gap: 11px; }
        .wil-dusun-header { align-items: flex-start; flex-direction: column; }
        .wil-actions { justify-content: flex-start; }
        .wil-rw-header { align-items: flex-start; flex-direction: column; }
        .wil-rt-list { margin-left: 0; }
    }

    @media (max-width: 650px) {
        .wil-page-heading { align-items: stretch; flex-direction: column; gap: 15px; }
        .wil-page-heading > .wil-btn { align-self: flex-start; }
        .wil-stats { grid-template-columns: 1fr; gap: 11px; margin-bottom: 23px; }
        .wil-stat { padding: 15px; }
        .wil-stat-icon { width: 42px; height: 42px; flex-basis: 42px; }
        .wil-stat-number { font-size: 25px; }
        .wil-create-panel { padding: 17px; }
        .wil-form-grid { grid-template-columns: 1fr; }
        .wil-form-grid > .wil-btn { justify-self: start; }
        .wil-dusun-header { padding: 16px; }
        .wil-dusun-identity { align-items: flex-start; }
        .wil-dusun-header h3 { font-size: 16px; }
        .wil-actions { width: 100%; }
        .wil-actions .wil-btn { padding: 7px 9px; }
        .wil-rw-list { padding: 4px 15px 14px; }
        .wil-rw { padding: 15px 0; }
        .wil-rw-header { gap: 12px; }
        .wil-rw-identity { gap: 10px; }
        .wil-rt-list { gap: 7px; }
        .wil-rt { gap: 7px; padding: 8px; }
        .wil-inline-form { padding: 13px 15px; }
        .wil-inline-row { align-items: stretch; }
        .wil-inline-row input { width: 100%; flex: 1 1 100%; }
        .wil-list-heading h2 { font-size: 16px; }
        .wil-total-badge { white-space: nowrap; }
    }

    @media (prefers-reduced-motion: reduce) {
        .wil-btn, .wil-stat, .wil-rt { transition: none; }
    }
</style>

<script>
    function wilToggle(id) {
        const element = document.getElementById(id);
        if (!element) return;

        element.hidden = !element.hidden;

        if (!element.hidden) {
            const input = element.querySelector('input:not([type="hidden"])');
            if (input) {
                setTimeout(() => input.focus(), 50);
            }
        }
    }
</script>

@endsection
