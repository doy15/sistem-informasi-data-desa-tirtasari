@extends('layouts.app')

@section('title', 'Pengaturan - Desa Tirtasari')
@section('page-title', 'Pengaturan')

@section('content')

<div class="settings-page">

    {{-- HEADER --}}
    <div class="page-header settings-page-header">
        <div>
            <h1>Pengaturan</h1>
            <p>Kelola informasi dan konfigurasi Sistem Informasi Desa Tirtasari.</p>
        </div>
    </div>

    <div class="settings-layout">

        {{-- MENU PENGATURAN --}}
        <aside class="settings-menu">

            <div class="settings-menu-title">
                Pengaturan Sistem
            </div>

            <button type="button" class="settings-menu-item active">
                <span class="settings-icon">🏛️</span>
                <span>Profil Desa</span>
            </button>

            <button type="button" class="settings-menu-item">
                <span class="settings-icon">👤</span>
                <span>Akun Pengguna</span>
            </button>

            <button type="button" class="settings-menu-item">
                <span class="settings-icon">🔐</span>
                <span>Keamanan</span>
            </button>

            <button type="button" class="settings-menu-item">
                <span class="settings-icon">⚙️</span>
                <span>Sistem</span>
            </button>

        </aside>

        {{-- KONTEN PENGATURAN --}}
        <div class="settings-content">

            {{-- PROFIL DESA --}}
            <section class="settings-card">

                <div class="settings-card-header">
                    <div class="settings-heading-icon">🏡</div>

                    <div>
                        <h3>Profil Desa</h3>
                        <p>
                            Informasi yang digunakan pada sistem dan dokumen
                            pelayanan desa.
                        </p>
                    </div>
                </div>

                <div class="settings-card-body">

                    <div class="form-grid">

                        <div class="form-group">
                            <label for="nama_desa">Nama Desa</label>
                            <input
                                id="nama_desa"
                                type="text"
                                name="nama_desa"
                                value="Desa Tirtasari"
                                placeholder="Masukkan nama desa"
                            >
                        </div>

                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <input
                                id="kecamatan"
                                type="text"
                                name="kecamatan"
                                placeholder="Masukkan nama kecamatan"
                            >
                        </div>

                        <div class="form-group">
                            <label for="kabupaten">Kabupaten</label>
                            <input
                                id="kabupaten"
                                type="text"
                                name="kabupaten"
                                placeholder="Masukkan nama kabupaten"
                            >
                        </div>

                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <input
                                id="provinsi"
                                type="text"
                                name="provinsi"
                                placeholder="Masukkan nama provinsi"
                            >
                        </div>

                        <div class="form-group form-full">
                            <label for="alamat">Alamat Kantor Desa</label>
                            <textarea
                                id="alamat"
                                name="alamat"
                                rows="3"
                                placeholder="Masukkan alamat kantor desa"
                            ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input
                                id="telepon"
                                type="tel"
                                name="telepon"
                                placeholder="Masukkan nomor telepon desa"
                            >
                        </div>

                        <div class="form-group">
                            <label for="email_desa">Email Desa</label>
                            <input
                                id="email_desa"
                                type="email"
                                name="email_desa"
                                placeholder="Masukkan email desa"
                            >
                        </div>

                    </div>

                    <div class="settings-actions">
                        <button type="button" class="settings-save-btn">
                            <span>✓</span>
                            Simpan Pengaturan
                        </button>
                    </div>

                </div>

            </section>

            {{-- INFORMASI SISTEM --}}
            <section class="settings-card">

                <div class="settings-card-header">
                    <div class="settings-heading-icon">🖥️</div>

                    <div>
                        <h3>Informasi Sistem</h3>
                        <p>Informasi aplikasi yang sedang digunakan.</p>
                    </div>
                </div>

                <div class="system-info">

                    <div class="system-info-item">
                        <span class="info-label">Nama Aplikasi</span>
                        <strong>Sistem Informasi Desa Tirtasari</strong>
                    </div>

                    <div class="system-info-item">
                        <span class="info-label">Versi Aplikasi</span>
                        <strong>1.0.0</strong>
                    </div>

                    <div class="system-info-item">
                        <span class="info-label">Status Database</span>
                        <strong class="status status-warning">
                            <span class="status-dot"></span>
                            Belum Terhubung
                        </strong>
                    </div>

                    <div class="system-info-item">
                        <span class="info-label">Dataset Penduduk</span>
                        <strong>Belum Diimpor</strong>
                    </div>

                </div>

            </section>

        </div>

    </div>

</div>

<style>
/* =========================================
   PENGATURAN - TEMA NAVY DESA TIRTASARI
========================================= */

/* =========================================
   PENGATURAN — RESPONSIVE LIGHT & DARK THEME
========================================= */

.settings-page {
    --sp-bg: #ffffff;
    --sp-panel: #ffffff;
    --sp-panel-header: #f8fafc;
    --sp-input: #ffffff;
    --sp-hover: #f1f5f9;
    --sp-active: #eff6ff;
    --sp-border: #e2e8f0;
    --sp-text: #0f172a;
    --sp-muted: #64748b;
    --sp-primary: #2563eb;
    --sp-primary-hover: #1d4ed8;
    --sp-icon-bg: #eff6ff;
    --sp-icon-border: #bfdbfe;
    --sp-active-text: #1d4ed8;
    --sp-placeholder: #94a3b8;

    width: 100%;
    min-width: 0;
    color: var(--sp-text);
}

.settings-page,
.settings-page * {
    box-sizing: border-box;
}

/* Tema gelap: gunakan jika layout memakai class dark atau data-theme */
.dark .settings-page,
.dark-mode .settings-page,
[data-theme="dark"] .settings-page,
[data-bs-theme="dark"] .settings-page,
body.dark .settings-page {
    --sp-bg: #0f172a;
    --sp-panel: #172438;
    --sp-panel-header: #132035;
    --sp-input: #0f1b2d;
    --sp-hover: #20324b;
    --sp-active: #203858;
    --sp-border: #293b55;
    --sp-text: #edf3ff;
    --sp-muted: #a9bddb;
    --sp-primary: #3478f6;
    --sp-primary-hover: #2563eb;
    --sp-icon-bg: #223b5e;
    --sp-icon-border: #304d74;
    --sp-active-text: #80b0ff;
    --sp-placeholder: #8198b8;
}

/* Header halaman */
.settings-page .settings-page-header {
    margin-bottom: 22px;
}

.settings-page .settings-page-header h1 {
    margin: 0 0 7px;
    color: var(--sp-text);
    font-size: 24px;
    font-weight: 750;
}

.settings-page .settings-page-header p {
    margin: 0;
    color: var(--sp-muted);
    font-size: 14px;
    line-height: 1.7;
}

/* Layout */
.settings-page .settings-layout {
    display: grid;
    grid-template-columns: 220px minmax(0, 1fr);
    align-items: start;
    gap: 20px;
}

/* Menu */
.settings-page .settings-menu {
    min-width: 0;
    overflow: hidden;
    background: var(--sp-panel);
    border: 1px solid var(--sp-border);
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
}

.settings-page .settings-menu-title {
    padding: 17px 16px;
    color: var(--sp-muted);
    background: var(--sp-panel-header);
    border-bottom: 1px solid var(--sp-border);
    font-size: 11px;
    font-weight: 750;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.settings-page .settings-menu-item {
    display: flex;
    align-items: center;
    gap: 11px;
    width: 100%;
    padding: 14px 16px;
    border: 0;
    border-left: 3px solid transparent;
    border-radius: 0;
    background: transparent;
    color: var(--sp-text);
    text-align: left;
    font-family: inherit;
    font-size: 13px;
    cursor: pointer;
    transition: background .2s ease, color .2s ease;
}

.settings-page .settings-menu-item:hover {
    background: var(--sp-hover);
}

.settings-page .settings-menu-item.active {
    background: var(--sp-active);
    border-left-color: var(--sp-primary);
    color: var(--sp-active-text);
    font-weight: 700;
}

.settings-page .settings-icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 22px;
    flex-shrink: 0;
    font-size: 15px;
}

/* Konten dan panel */
.settings-page .settings-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 0;
}

.settings-page .settings-card {
    min-width: 0;
    overflow: hidden;
    margin: 0;
    background: var(--sp-panel);
    border: 1px solid var(--sp-border);
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
}

.settings-page .settings-card-header {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 21px 22px;
    background: var(--sp-panel-header);
    border-bottom: 1px solid var(--sp-border);
}

.settings-page .settings-heading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 39px;
    height: 39px;
    flex-shrink: 0;
    background: var(--sp-icon-bg);
    border: 1px solid var(--sp-icon-border);
    border-radius: 10px;
    font-size: 17px;
}

.settings-page .settings-card-header h3 {
    margin: 1px 0 6px;
    color: var(--sp-text);
    font-size: 17px;
    font-weight: 700;
}

.settings-page .settings-card-header p {
    margin: 0;
    color: var(--sp-muted);
    font-size: 13px;
    line-height: 1.7;
}

/* Form */
.settings-page .settings-card-body {
    padding: 22px;
}

.settings-page .form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
    padding: 0;
}

.settings-page .form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 0;
}

.settings-page .form-group label {
    color: var(--sp-text);
    font-size: 13px;
    font-weight: 600;
}

.settings-page .form-group input,
.settings-page .form-group textarea,
.settings-page .form-group select {
    display: block;
    width: 100%;
    min-width: 0;
    padding: 12px 13px;
    border: 1px solid var(--sp-border);
    border-radius: 9px;
    outline: none;
    background: var(--sp-input);
    color: var(--sp-text);
    font-family: inherit;
    font-size: 13px;
    line-height: 1.5;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.settings-page .form-group input {
    min-height: 44px;
}

.settings-page .form-group textarea {
    min-height: 95px;
    resize: vertical;
}

.settings-page .form-group input::placeholder,
.settings-page .form-group textarea::placeholder {
    color: var(--sp-placeholder);
    opacity: 1;
}

.settings-page .form-group input:focus,
.settings-page .form-group textarea:focus,
.settings-page .form-group select:focus {
    border-color: var(--sp-primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .14);
}

.settings-page .form-full {
    grid-column: 1 / -1;
}

/* Tombol simpan */
.settings-page .settings-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 22px;
}

.settings-page .settings-save-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 9px;
    min-height: 43px;
    padding: 11px 18px;
    border: 1px solid var(--sp-primary);
    border-radius: 9px;
    background: var(--sp-primary);
    color: #ffffff;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
}

.settings-page .settings-save-btn:hover {
    background: var(--sp-primary-hover);
    transform: translateY(-1px);
}

.settings-page .settings-save-btn span {
    font-size: 15px;
}

/* Informasi sistem */
.settings-page .system-info {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.settings-page .system-info-item {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
    min-width: 0;
    padding: 20px 22px;
    border-bottom: 1px solid var(--sp-border);
}

.settings-page .system-info-item:nth-child(odd) {
    border-right: 1px solid var(--sp-border);
}

.settings-page .system-info-item:nth-last-child(-n+2) {
    border-bottom: 0;
}

.settings-page .info-label {
    color: var(--sp-muted);
    font-size: 12px;
}

.settings-page .system-info-item strong {
    color: var(--sp-text);
    font-size: 13px;
    font-weight: 650;
    line-height: 1.6;
    overflow-wrap: anywhere;
}

.settings-page .system-info-item .status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.settings-page .status-warning {
    color: #b45309;
}

.dark .settings-page .status-warning,
.dark-mode .settings-page .status-warning,
[data-theme="dark"] .settings-page .status-warning,
[data-bs-theme="dark"] .settings-page .status-warning,
body.dark .settings-page .status-warning {
    color: #fbbf64;
}

.settings-page .status-dot {
    width: 8px;
    height: 8px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #f59e0b;
}

/* Tablet */
@media (max-width: 1000px) {
    .settings-page .settings-layout {
        grid-template-columns: 190px minmax(0, 1fr);
        gap: 14px;
    }

    .settings-page .settings-card-body {
        padding: 18px;
    }

    .settings-page .settings-card-header {
        padding: 18px;
    }

    .settings-page .form-grid {
        gap: 16px;
    }
}

/* HP */
@media (max-width: 700px) {
    .settings-page .settings-layout {
        grid-template-columns: minmax(0, 1fr);
    }

    .settings-page .settings-menu {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .settings-page .settings-menu-title {
        grid-column: 1 / -1;
    }

    .settings-page .settings-menu-item {
        padding: 12px;
        font-size: 12px;
    }

    .settings-page .form-grid,
    .settings-page .system-info {
        grid-template-columns: minmax(0, 1fr);
    }

    .settings-page .form-full {
        grid-column: auto;
    }

    .settings-page .system-info-item,
    .settings-page .system-info-item:nth-child(odd),
    .settings-page .system-info-item:nth-last-child(-n+2) {
        border-right: 0;
        border-bottom: 1px solid var(--sp-border);
    }

    .settings-page .system-info-item:last-child {
        border-bottom: 0;
    }

    .settings-page .settings-card-body,
    .settings-page .settings-card-header {
        padding: 16px;
    }

    .settings-page .settings-actions {
        padding-top: 18px;
    }

    .settings-page .settings-save-btn {
        width: 100%;
    }
}
</style>

@endsection