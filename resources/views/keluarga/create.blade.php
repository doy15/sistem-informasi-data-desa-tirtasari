@extends('layouts.app')

@section('title', 'Tambah Kartu Keluarga - Desa Tirtasari')

@section('page-title', 'Tambah Kartu Keluarga')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Kartu Keluarga</h1>
        <p>Tambahkan data Kartu Keluarga baru.</p>
    </div>

    <a
        href="{{ route('keluarga.index') }}"
        class="btn-secondary"
    >
        ← Kembali
    </a>

</div>


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


<div class="card">

    <div class="card-header">

        <h2>Data Kartu Keluarga</h2>

        <p>
            Isi informasi dasar Kartu Keluarga.
        </p>

    </div>


    <form
        action="{{ route('keluarga.store') }}"
        method="POST"
    >

        @csrf


        <div class="form-grid">


            {{-- NOMOR KK --}}
            <div class="form-group">

                <label for="no_kk">
                    Nomor Kartu Keluarga
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="no_kk"
                    name="no_kk"
                    value="{{ old('no_kk') }}"
                    maxlength="16"
                    minlength="16"
                    inputmode="numeric"
                    pattern="[0-9]{16}"
                    placeholder="Masukkan 16 digit No. KK"
                    required
                >

                <small>
                    Nomor KK harus terdiri dari 16 digit.
                </small>

            </div>


            {{-- WILAYAH RT --}}
            <div class="form-group">

                <label for="rt_id">
                    Wilayah RT
                    <span class="required">*</span>
                </label>

                <select
                    id="rt_id"
                    name="rt_id"
                    required
                >

                    <option value="">
                        -- Pilih RT --
                    </option>

                    @foreach ($rts as $rt)

                        <option
                            value="{{ $rt->id }}"
                            {{ old('rt_id') == $rt->id ? 'selected' : '' }}
                        >

                            RT {{ $rt->nomor }}
                            /
                            RW {{ $rt->rw?->nomor ?? '-' }}
                            /
                            {{ $rt->rw?->dusun?->nama ?? '-' }}

                        </option>

                    @endforeach

                </select>

                <small>
                    Pilih RT sesuai wilayah tempat tinggal KK.
                </small>

            </div>


            {{-- ALAMAT --}}
            <div class="form-group form-group-full">

                <label for="alamat">
                    Alamat
                    <span class="required">*</span>
                </label>

                <textarea
                    id="alamat"
                    name="alamat"
                    rows="4"
                    maxlength="500"
                    placeholder="Contoh: Kp. Nagasari No. 12"
                    required
                >{{ old('alamat') }}</textarea>

            </div>

        </div>


        {{-- PREVIEW WILAYAH --}}
        <div class="wilayah-preview">

            <div>

                <span>RT</span>

                <strong id="preview-rt">
                    -
                </strong>

            </div>


            <div>

                <span>RW</span>

                <strong id="preview-rw">
                    -
                </strong>

            </div>


            <div>

                <span>Dusun</span>

                <strong id="preview-dusun">
                    -
                </strong>

            </div>

        </div>


        <div class="form-actions">

            <a
                href="{{ route('keluarga.index') }}"
                class="btn-secondary"
            >
                Batal
            </a>


            <button
                type="submit"
                class="btn-primary"
            >
                Simpan Kartu Keluarga
            </button>

        </div>

    </form>

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
    font-size: 28px;
}

.page-header p {
    margin: 0;
    color: #64748b;
}


.card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
}

.card-header {
    padding: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.card-header h2 {
    margin: 0 0 6px;
    font-size: 20px;
}

.card-header p {
    margin: 0;
    color: #64748b;
}


form {
    padding: 24px;
}


.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}


.form-group {
    display: flex;
    flex-direction: column;
}


.form-group-full {
    grid-column: 1 / -1;
}


.form-group label {
    margin-bottom: 8px;
    font-weight: 600;
}


.required {
    color: #dc2626;
}


.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 11px 13px;
    font-size: 15px;
    background: #fff;
}


.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #16a34a;
    box-shadow: 0 0 0 3px rgba(22, 163, 74, .10);
}


.form-group small {
    margin-top: 6px;
    color: #64748b;
}


.wilayah-preview {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;

    margin-top: 24px;
    padding: 18px;

    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
}


.wilayah-preview div {
    display: flex;
    flex-direction: column;
    gap: 5px;
}


.wilayah-preview span {
    font-size: 12px;
    color: #64748b;
}


.wilayah-preview strong {
    font-size: 16px;
}


.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;

    margin-top: 28px;
    padding-top: 20px;

    border-top: 1px solid #e2e8f0;
}


.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 10px 16px;

    border-radius: 8px;

    text-decoration: none;

    font-weight: 600;

    cursor: pointer;
}


.btn-primary {
    border: none;
    background: #16a34a;
    color: #fff;
}


.btn-primary:hover {
    background: #15803d;
}


.btn-secondary {
    border: 1px solid #cbd5e1;
    background: #fff;
    color: #334155;
}


.btn-secondary:hover {
    background: #f8fafc;
}


.alert {
    margin-bottom: 20px;
    padding: 14px 16px;
    border-radius: 10px;
}


.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}


.alert ul {
    margin: 8px 0 0 20px;
}


@media (max-width: 700px) {

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group-full {
        grid-column: auto;
    }

    .wilayah-preview {
        grid-template-columns: 1fr;
    }

    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

}

</style>


<script>

    const rtData = {!! json_encode($rtData) !!};


    const rtSelect =
        document.getElementById('rt_id');

    const previewRt =
        document.getElementById('preview-rt');

    const previewRw =
        document.getElementById('preview-rw');

    const previewDusun =
        document.getElementById('preview-dusun');


    function updateWilayahPreview() {

        const rtId = rtSelect.value;


        if (!rtId || !rtData[rtId]) {

            previewRt.textContent = '-';
            previewRw.textContent = '-';
            previewDusun.textContent = '-';

            return;
        }


        const data = rtData[rtId];


        previewRt.textContent =
            String(data.rt).padStart(2, '0');


        previewRw.textContent =
            String(data.rw).padStart(2, '0');


        previewDusun.textContent =
            data.dusun ?? '-';

    }


    rtSelect.addEventListener(
        'change',
        updateWilayahPreview
    );


    updateWilayahPreview();

</script>

@endsection