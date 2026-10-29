@extends('layouts.app')

@section('title', 'Edit Penduduk')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 16px;
    }

    .page-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 8px;
        background: #f3f4f6;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-back:hover {
        background: #e5e7eb;
    }

    .form-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .section-header {
        padding: 16px 20px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .section-header p {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .form-body {
        padding: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        color: #111827;
        background: #fff;
        outline: none;
    }

    .form-control:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.10);
    }

    .form-control[readonly] {
        background: #f9fafb;
        color: #6b7280;
    }

    .form-help {
        font-size: 12px;
        color: #6b7280;
    }

    .error-text {
        font-size: 12px;
        color: #dc2626;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .preview-box {
        margin-top: 18px;
        padding: 16px;
        border: 1px dashed #d1d5db;
        border-radius: 10px;
        background: #f9fafb;
    }

    .preview-title {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 12px;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .preview-item span {
        display: block;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .preview-item strong {
        font-size: 13px;
        color: #111827;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 10px;
    }

    .btn {
        border: 0;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    .btn-save {
        background: #16a34a;
        color: #fff;
    }

    .btn-save:hover {
        background: #15803d;
    }

    @media (max-width: 800px) {
        .form-grid,
        .preview-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="page-header">

    <div>

        <h1 class="page-title">
            Edit Data Penduduk
        </h1>

        <p class="page-subtitle">
            Perbarui informasi penduduk yang tersimpan di sistem.
        </p>

    </div>

    <a
        href="{{ route('penduduk.show', $penduduk->id) }}"
        class="btn-back"
    >
        ← Kembali ke Detail
    </a>

</div>


{{-- =========================================================
     SUCCESS MESSAGE
========================================================= --}}

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- =========================================================
     VALIDATION ERROR
========================================================= --}}

@if($errors->any())

    <div class="alert alert-error">

        <strong>
            Data belum bisa disimpan.
        </strong>

        <ul style="margin: 8px 0 0 18px;">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- =========================================================
     FORM UTAMA
========================================================= --}}

<form
    action="{{ route('penduduk.update', $penduduk->id) }}"
    method="POST"
>

    @csrf

    @method('PUT')


    {{-- =====================================================
         IDENTITAS PENDUDUK
    ====================================================== --}}

    <div class="form-card">

        <div class="section-header">

            <h3>
                Identitas Penduduk
            </h3>

            <p>
                Informasi dasar identitas penduduk.
            </p>

        </div>


        <div class="form-body">

            <div class="form-grid">


                {{-- NIK --}}
                <div class="form-group">

                    <label class="form-label">
                        NIK <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="nik"
                        class="form-control"
                        value="{{ old('nik', $penduduk->nik) }}"
                        maxlength="16"
                        minlength="16"
                        inputmode="numeric"
                        required
                    >

                    <span class="form-help">
                        NIK harus terdiri dari 16 digit.
                    </span>

                    @error('nik')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- NAMA --}}
                <div class="form-group">

                    <label class="form-label">
                        Nama Lengkap <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        class="form-control"
                        value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}"
                        required
                    >

                    @error('nama_lengkap')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- JENIS KELAMIN --}}
                <div class="form-group">

                    <label class="form-label">
                        Jenis Kelamin <span class="required">*</span>
                    </label>

                    <select
                        name="jenis_kelamin"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Jenis Kelamin --
                        </option>

                        <option
                            value="LAKI-LAKI"
                            {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'LAKI-LAKI' ? 'selected' : '' }}
                        >
                            Laki-laki
                        </option>

                        <option
                            value="PEREMPUAN"
                            {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'PEREMPUAN' ? 'selected' : '' }}
                        >
                            Perempuan
                        </option>

                    </select>

                    @error('jenis_kelamin')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- GOLONGAN DARAH --}}
                <div class="form-group">

                    <label class="form-label">
                        Golongan Darah
                    </label>

                    <select
                        name="golongan_darah"
                        class="form-control"
                    >

                        <option value="">
                            -- Pilih Golongan Darah --
                        </option>

                        @foreach(['A', 'B', 'AB', 'O'] as $goldar)

                            <option
                                value="{{ $goldar }}"
                                {{ old('golongan_darah', $penduduk->golongan_darah) == $goldar ? 'selected' : '' }}
                            >
                                {{ $goldar }}
                            </option>

                        @endforeach

                    </select>

                    @error('golongan_darah')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- TEMPAT LAHIR --}}
                <div class="form-group">

                    <label class="form-label">
                        Tempat Lahir <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="tempat_lahir"
                        class="form-control"
                        value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}"
                        required
                    >

                    @error('tempat_lahir')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- TANGGAL LAHIR --}}
                <div class="form-group">

                    <label class="form-label">
                        Tanggal Lahir <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_lahir"
                        class="form-control"
                        value="{{ old('tanggal_lahir', optional($penduduk->tanggal_lahir)->format('Y-m-d')) }}"
                        required
                    >

                    @error('tanggal_lahir')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DATA KELUARGA
    ====================================================== --}}

    <div class="form-card">

        <div class="section-header">

            <h3>
                Data Keluarga
            </h3>

            <p>
                Hubungan penduduk dengan kartu keluarga.
            </p>

        </div>


        <div class="form-body">

            <div class="form-grid">


                {{-- KARTU KELUARGA --}}
                <div class="form-group">

                    <label class="form-label">
                        Kartu Keluarga <span class="required">*</span>
                    </label>

                    <select
                        name="kartu_keluarga_id"
                        id="kartu_keluarga_id"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Kartu Keluarga --
                        </option>


                        @foreach($kartuKeluargas as $kk)

                            @php

                                $rt = $kk->rt;
                                $rw = $rt?->rw;
                                $dusun = $rw?->dusun;

                            @endphp


                            <option
                                value="{{ $kk->id }}"
                                {{ old('kartu_keluarga_id', $penduduk->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}
                            >

                                {{ $kk->no_kk }}

                                — RT {{ $rt?->nomor ?? '-' }}

                                / RW {{ $rw?->nomor ?? '-' }}

                                — {{ $dusun?->nama ?? '-' }}

                            </option>

                        @endforeach

                    </select>


                    @error('kartu_keluarga_id')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- STATUS HUBUNGAN KELUARGA --}}
                <div class="form-group">

                    <label class="form-label">

                        Status Hubungan Keluarga

                        <span class="required">*</span>

                    </label>


                    @php

                        $statusHubungan = [
                            'KEPALA KELUARGA',
                            'ISTRI',
                            'SUAMI',
                            'ANAK',
                            'MENANTU',
                            'CUCU',
                            'ORANG TUA',
                            'MERTUA',
                            'FAMILI LAIN',
                            'PEMBANTU',
                            'LAINNYA',
                        ];

                    @endphp


                    <select
                        name="status_hubungan_keluarga"
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Status --
                        </option>


                        @foreach($statusHubungan as $status)

                            <option
                                value="{{ $status }}"
                                {{ old('status_hubungan_keluarga', $penduduk->status_hubungan_keluarga) == $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>


                    @error('status_hubungan_keluarga')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>


            {{-- PREVIEW WILAYAH KK --}}

            <div class="preview-box">

                <div class="preview-title">
                    Informasi Wilayah Kartu Keluarga
                </div>


                <div class="preview-grid">


                    <div class="preview-item">

                        <span>
                            No. KK
                        </span>

                        <strong id="preview-kk">
                            -
                        </strong>

                    </div>


                    <div class="preview-item">

                        <span>
                            Alamat
                        </span>

                        <strong id="preview-alamat">
                            -
                        </strong>

                    </div>


                    <div class="preview-item">

                        <span>
                            RT / RW
                        </span>

                        <strong id="preview-rt-rw">
                            -
                        </strong>

                    </div>


                    <div class="preview-item">

                        <span>
                            Dusun
                        </span>

                        <strong id="preview-dusun">
                            -
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DATA KEPENDUDUKAN
    ====================================================== --}}

    <div class="form-card">

        <div class="section-header">

            <h3>
                Data Kependudukan
            </h3>

            <p>
                Informasi tambahan penduduk.
            </p>

        </div>


        <div class="form-body">

            <div class="form-grid">


                {{-- AGAMA --}}
                <div class="form-group">

                    <label class="form-label">
                        Agama
                    </label>

                    <select
                        name="agama"
                        class="form-control"
                    >

                        <option value="">
                            -- Pilih Agama --
                        </option>


                        @foreach([
                            'ISLAM',
                            'KRISTEN',
                            'KATOLIK',
                            'HINDU',
                            'BUDDHA',
                            'KONGHUCU',
                            'LAINNYA'
                        ] as $agama)

                            <option
                                value="{{ $agama }}"
                                {{ old('agama', $penduduk->agama) == $agama ? 'selected' : '' }}
                            >
                                {{ $agama }}
                            </option>

                        @endforeach

                    </select>


                    @error('agama')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- PENDIDIKAN --}}
                <div class="form-group">

                    <label class="form-label">
                        Pendidikan Terakhir
                    </label>

                    <input
                        type="text"
                        name="pendidikan_akhir"
                        class="form-control"
                        value="{{ old('pendidikan_akhir', $penduduk->pendidikan_akhir) }}"
                    >

                    @error('pendidikan_akhir')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- PEKERJAAN --}}
                <div class="form-group">

                    <label class="form-label">
                        Jenis Pekerjaan
                    </label>

                    <input
                        type="text"
                        name="jenis_pekerjaan"
                        class="form-control"
                        value="{{ old('jenis_pekerjaan', $penduduk->jenis_pekerjaan) }}"
                    >

                    @error('jenis_pekerjaan')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- STATUS PERKAWINAN --}}
                <div class="form-group">

                    <label class="form-label">
                        Status Perkawinan
                    </label>

                    <select
                        name="status_perkawinan"
                        class="form-control"
                    >

                        <option value="">
                            -- Pilih Status --
                        </option>


                        @foreach([
                            'BELUM KAWIN',
                            'KAWIN',
                            'CERAI HIDUP',
                            'CERAI MATI'
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                {{ old('status_perkawinan', $penduduk->status_perkawinan) == $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>


                    @error('status_perkawinan')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DATA ORANG TUA
    ====================================================== --}}

    <div class="form-card">

        <div class="section-header">

            <h3>
                Data Orang Tua
            </h3>

            <p>
                Informasi nama ibu dan ayah.
            </p>

        </div>


        <div class="form-body">

            <div class="form-grid">


                {{-- NAMA IBU --}}
                <div class="form-group">

                    <label class="form-label">
                        Nama Ibu
                    </label>

                    <input
                        type="text"
                        name="nama_ibu"
                        class="form-control"
                        value="{{ old('nama_ibu', $penduduk->nama_ibu) }}"
                    >

                    @error('nama_ibu')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- NAMA AYAH --}}
                <div class="form-group">

                    <label class="form-label">
                        Nama Ayah
                    </label>

                    <input
                        type="text"
                        name="nama_ayah"
                        class="form-control"
                        value="{{ old('nama_ayah', $penduduk->nama_ayah) }}"
                    >

                    @error('nama_ayah')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DOKUMEN & INFORMASI TAMBAHAN
    ====================================================== --}}

    <div class="form-card">

        <div class="section-header">

            <h3>
                Dokumen & Informasi Tambahan
            </h3>

            <p>
                Data paspor dan informasi HB.
            </p>

        </div>


        <div class="form-body">

            <div class="form-grid">


                {{-- NOMOR PASPOR --}}
                <div class="form-group">

                    <label class="form-label">
                        Nomor Paspor
                    </label>

                    <input
                        type="text"
                        name="no_paspor"
                        class="form-control"
                        value="{{ old('no_paspor', $penduduk->no_paspor) }}"
                    >

                    @error('no_paspor')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- TANGGAL AKHIR PASPOR --}}
                <div class="form-group">

                    <label class="form-label">
                        Tanggal Akhir Paspor
                    </label>

                    <input
                        type="date"
                        name="tanggal_akhir_paspor"
                        class="form-control"
                        value="{{ old('tanggal_akhir_paspor', optional($penduduk->tanggal_akhir_paspor)->format('Y-m-d')) }}"
                    >

                    @error('tanggal_akhir_paspor')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- HB --}}
                <div class="form-group full">

                    <label class="form-label">
                        HB
                    </label>

                    <input
                        type="text"
                        name="hb"
                        class="form-control"
                        value="{{ old('hb', $penduduk->hb) }}"
                    >

                    @error('hb')

                        <span class="error-text">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TOMBOL
    ====================================================== --}}

    <div class="form-actions">

        <a
            href="{{ route('penduduk.show', $penduduk->id) }}"
            class="btn btn-cancel"
        >
            Batal
        </a>

        <button
            type="submit"
            class="btn btn-save"
        >
            Simpan Perubahan
        </button>

    </div>

</form>


{{-- =========================================================
     DATA KK UNTUK JAVASCRIPT
========================================================= --}}

@php

    $kartuKeluargaData = [];

    foreach ($kartuKeluargas as $kk) {

        $kartuKeluargaData[$kk->id] = [
            'no_kk' => $kk->no_kk,
            'alamat' => $kk->alamat,
            'rt' => $kk->rt?->nomor,
            'rw' => $kk->rt?->rw?->nomor,
            'dusun' => $kk->rt?->rw?->dusun?->nama,
        ];

    }

@endphp


<script>

    const kartuKeluargaData =
        {!! json_encode($kartuKeluargaData) !!};


    const kkSelect =
        document.getElementById('kartu_keluarga_id');


    function updateKkPreview() {

        if (!kkSelect) {
            return;
        }


        const kkId =
            kkSelect.value;


        const data =
            kartuKeluargaData[kkId];


        if (!data) {

            document.getElementById('preview-kk').textContent = '-';

            document.getElementById('preview-alamat').textContent = '-';

            document.getElementById('preview-rt-rw').textContent = '-';

            document.getElementById('preview-dusun').textContent = '-';

            return;
        }


        document.getElementById('preview-kk').textContent =
            data.no_kk || '-';


        document.getElementById('preview-alamat').textContent =
            data.alamat || '-';


        document.getElementById('preview-rt-rw').textContent =
            'RT ' + (data.rt || '-') +
            ' / RW ' + (data.rw || '-');


        document.getElementById('preview-dusun').textContent =
            data.dusun || '-';

    }


    if (kkSelect) {

        kkSelect.addEventListener(
            'change',
            updateKkPreview
        );


        updateKkPreview();

    }

</script>

@endsection