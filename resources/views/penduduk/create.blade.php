@extends('layouts.app')

@section('title', 'Tambah Penduduk - Desa Tirtasari')

@section('page-title', 'Tambah Penduduk')

@section('content')

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Data belum bisa disimpan.</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="page-header">
    <div>
        <h1>Tambah Penduduk</h1>
        <p>Masukkan data penduduk baru.</p>
    </div>

    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>


<form
    method="POST"
    action="{{ route('penduduk.store') }}"
>
    @csrf


    {{-- DATA IDENTITAS --}}
    <div class="form-card">
        <div class="form-card-header">
            <h3>Identitas Penduduk</h3>
            <p>Data dasar identitas warga.</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>NIK <span class="required">*</span></label>

                <input
                    type="text"
                    name="nik"
                    value="{{ old('nik') }}"
                    placeholder="Masukkan 16 digit NIK"
                    maxlength="16"
                    inputmode="numeric"
                    required
                >

                <small>NIK harus terdiri dari 16 digit angka.</small>
            </div>


            <div class="form-group">
                <label>Nama Lengkap <span class="required">*</span></label>

                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>


            <div class="form-group">
                <label>Jenis Kelamin <span class="required">*</span></label>

                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>

                    <option
                        value="Laki-laki"
                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}
                    >
                        Laki-laki
                    </option>

                    <option
                        value="Perempuan"
                        {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}
                    >
                        Perempuan
                    </option>
                </select>
            </div>


            <div class="form-group">
                <label>Golongan Darah</label>

                <select name="golongan_darah">
                    <option value="">-- Pilih Golongan Darah --</option>

                    @foreach (['A', 'B', 'AB', 'O', 'Tidak Tahu'] as $golongan)
                        <option
                            value="{{ $golongan }}"
                            {{ old('golongan_darah') == $golongan ? 'selected' : '' }}
                        >
                            {{ $golongan }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Tempat Lahir <span class="required">*</span></label>

                <input
                    type="text"
                    name="tempat_lahir"
                    value="{{ old('tempat_lahir') }}"
                    placeholder="Contoh: Subang"
                    required
                >
            </div>


            <div class="form-group">
                <label>Tanggal Lahir <span class="required">*</span></label>

                <input
                    type="date"
                    name="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}"
                    required
                >
            </div>

        </div>
    </div>


    {{-- DATA KELUARGA --}}
    <div class="form-card">
        <div class="form-card-header">
            <h3>Data Keluarga</h3>
            <p>Hubungkan penduduk dengan Kartu Keluarga.</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Kartu Keluarga <span class="required">*</span></label>

                <select
                    name="kartu_keluarga_id"
                    id="kartu_keluarga_id"
                    required
                >
                    <option value="">-- Pilih Kartu Keluarga --</option>

                    @foreach ($kartuKeluargas as $kk)
                        <option
                            value="{{ $kk->id }}"
                            {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}
                        >
                            {{ $kk->no_kk }}
                            -
                            {{ $kk->penduduks->firstWhere('status_hubungan_keluarga', 'Kepala Keluarga')->nama_lengkap ?? 'Kepala Keluarga belum diisi' }}
                        </option>
                    @endforeach
                </select>

                <small>
                    Wilayah penduduk mengikuti wilayah Kartu Keluarga.
                </small>
            </div>


            <div class="form-group">
                <label>Status Hubungan Keluarga <span class="required">*</span></label>

                <select
                    name="status_hubungan_keluarga"
                    required
                >
                    <option value="">-- Pilih Status --</option>

                    @foreach ([
                        'KEPALA KELUARGA',
                        'ISTRI',
                        'ANAK',
                        'CUCU',
                        'MENANTU',
                        'ORANG TUA',
                        'KELUARGA LAINNYA'
                    ] as $status)

                        <option
                            value="{{ $status }}"
                            {{ old('status_hubungan_keluarga') == $status ? 'selected' : '' }}
                        >
                            {{ $status }}
                        </option>

                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Nama Lengkap Ibu</label>

                <input
                    type="text"
                    name="nama_ibu"
                    value="{{ old('nama_ibu') }}"
                    placeholder="Masukkan nama ibu"
                >
            </div>


            <div class="form-group">
                <label>Nama Lengkap Ayah</label>

                <input
                    type="text"
                    name="nama_ayah"
                    value="{{ old('nama_ayah') }}"
                    placeholder="Masukkan nama ayah"
                >
            </div>

        </div>
    </div>


    {{-- ALAMAT & WILAYAH --}}
    <div class="form-card">
        <div class="form-card-header">
            <h3>Alamat & Wilayah</h3>
            <p>Informasi tempat tinggal penduduk.</p>
        </div>

        <div class="form-grid">

            <div class="form-group form-full">
                <label>Alamat</label>

                <textarea
                    id="alamat"
                    rows="3"
                    placeholder="Alamat akan mengikuti Kartu Keluarga"
                    readonly
                ></textarea>

                <small>
                    Alamat diambil otomatis dari Kartu Keluarga yang dipilih.
                </small>
            </div>


            <div class="form-group">
                <label>RT</label>

                <input
                    type="text"
                    id="rt"
                    value=""
                    readonly
                    placeholder="-"
                >
            </div>


            <div class="form-group">
                <label>RW</label>

                <input
                    type="text"
                    id="rw"
                    value=""
                    readonly
                    placeholder="-"
                >
            </div>


            <div class="form-group">
                <label>Dusun</label>

                <input
                    type="text"
                    id="dusun"
                    value=""
                    readonly
                    placeholder="-"
                >
            </div>

        </div>
    </div>


    {{-- DATA LAINNYA --}}
    <div class="form-card">
        <div class="form-card-header">
            <h3>Data Kependudukan Lainnya</h3>
            <p>Pendidikan, pekerjaan, agama, dan status perkawinan.</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Agama</label>

                <select name="agama">
                    <option value="">-- Pilih Agama --</option>

                    @foreach ([
                        'Islam',
                        'Kristen',
                        'Katolik',
                        'Hindu',
                        'Buddha',
                        'Konghucu'
                    ] as $agama)

                        <option
                            value="{{ $agama }}"
                            {{ old('agama') == $agama ? 'selected' : '' }}
                        >
                            {{ $agama }}
                        </option>

                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Pendidikan Terakhir</label>

                <input
                    type="text"
                    name="pendidikan_akhir"
                    value="{{ old('pendidikan_akhir') }}"
                    placeholder="Contoh: SMA"
                >
            </div>


            <div class="form-group">
                <label>Jenis Pekerjaan</label>

                <input
                    type="text"
                    name="jenis_pekerjaan"
                    value="{{ old('jenis_pekerjaan') }}"
                    placeholder="Masukkan pekerjaan"
                >
            </div>


            <div class="form-group">
                <label>Status Perkawinan</label>

                <select name="status_perkawinan">
                    <option value="">-- Pilih Status --</option>

                    @foreach ([
                        'Belum Kawin',
                        'Kawin',
                        'Cerai Hidup',
                        'Cerai Mati'
                    ] as $status)

                        <option
                            value="{{ $status }}"
                            {{ old('status_perkawinan') == $status ? 'selected' : '' }}
                        >
                            {{ $status }}
                        </option>

                    @endforeach
                </select>
            </div>

        </div>
    </div>


    {{-- DOKUMEN --}}
    <div class="form-card">
        <div class="form-card-header">
            <h3>Dokumen Tambahan</h3>
            <p>Diisi jika data tersedia.</p>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Nomor Paspor</label>

                <input
                    type="text"
                    name="no_paspor"
                    value="{{ old('no_paspor') }}"
                    placeholder="Opsional"
                >
            </div>


            <div class="form-group">
                <label>Tanggal Akhir Paspor</label>

                <input
                    type="date"
                    name="tanggal_akhir_paspor"
                    value="{{ old('tanggal_akhir_paspor') }}"
                >
            </div>


            <div class="form-group">
                <label>HB</label>

                <input
                    type="text"
                    name="hb"
                    value="{{ old('hb') }}"
                    placeholder="Opsional"
                >
            </div>

        </div>
    </div>


    <div class="form-actions">

        <a
            href="{{ route('penduduk.index') }}"
            class="btn btn-secondary"
        >
            Batal
        </a>

        <button
            type="submit"
            class="btn"
        >
            Simpan Data Penduduk
        </button>

    </div>

</form>


<style>

    .alert {
        padding: 14px 18px;
        margin-bottom: 20px;
        border-radius: 9px;
        font-size: 14px;
    }

    .alert-error {
        background: #fdecec;
        color: #991b1b;
        border: 1px solid #f5c2c0;
    }

    .alert ul {
        margin: 8px 0 0 20px;
    }

    .required {
        color: #dc2626;
    }

    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .form-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-card-header h3 {
        font-size: 17px;
        margin: 0 0 5px;
    }

    .form-card-header p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2e7d32;
    }

    .form-group input[readonly],
    .form-group textarea[readonly] {
        background: #f9fafb;
        color: #4b5563;
        cursor: not-allowed;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group small {
        font-size: 11px;
        color: #6b7280;
    }

    .form-full {
        grid-column: 1 / -1;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-bottom: 30px;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    @media (max-width: 700px) {

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-full {
            grid-column: auto;
        }

    }

</style>


<script>

    const kartuKeluargaData = {!! json_encode(
        $kartuKeluargas->mapWithKeys(function ($kk) {
            return [
                $kk->id => [
                    'alamat' => $kk->alamat,
                    'rt' => $kk->rt?->nomor,
                    'rw' => $kk->rt?->rw?->nomor,
                    'dusun' => $kk->rt?->rw?->dusun?->nama,
                ],
            ];
        })->toArray()
    ) !!};

    const kartuKeluargaSelect =
        document.getElementById('kartu_keluarga_id');

    const alamatInput =
        document.getElementById('alamat');

    const rtInput =
        document.getElementById('rt');

    const rwInput =
        document.getElementById('rw');

    const dusunInput =
        document.getElementById('dusun');


    function updateWilayah() {

        const kkId = kartuKeluargaSelect.value;

        if (!kkId || !kartuKeluargaData[kkId]) {

            alamatInput.value = '';
            rtInput.value = '';
            rwInput.value = '';
            dusunInput.value = '';

            return;
        }

        const data = kartuKeluargaData[kkId];

        alamatInput.value = data.alamat ?? '';

        rtInput.value = data.rt
            ? String(data.rt).padStart(2, '0')
            : '';

        rwInput.value = data.rw
            ? String(data.rw).padStart(2, '0')
            : '';

        dusunInput.value = data.dusun ?? '';
    }


    kartuKeluargaSelect.addEventListener(
        'change',
        updateWilayah
    );


    updateWilayah();

</script>

@endsection