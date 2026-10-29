@extends('layouts.app')

@section('title', 'Tentang Akun - Desa Tirtasari')
@section('page-title', 'Tentang Akun')

@section('content')

<div class="account-page">

    {{-- HEADER HALAMAN --}}
    <div class="page-header account-page-header">
        <div>
            <h1>Tentang Akun</h1>
            <p>Informasi akun administrator yang sedang digunakan.</p>
        </div>
    </div>

    {{-- KARTU AKUN --}}
    <div class="account-card">

        <div class="account-avatar">
            AD
        </div>

        <h2>{{ auth()->user()->name }}</h2>
        <p class="account-role">Administrator Desa Tirtasari</p>

        <div class="account-badge">
            <span class="account-status-dot"></span>
            Akun Administrator
        </div>

        {{-- INFORMASI AKUN --}}
        <div class="account-info">

            <div class="account-info-item">
                <div class="account-info-icon">👤</div>
                <div class="account-info-content">
                    <span>Nama Pengguna</span>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
            </div>

            <div class="account-info-item">
                <div class="account-info-icon">✉️</div>
                <div class="account-info-content">
                    <span>Email</span>
                    <strong>{{ auth()->user()->email }}</strong>
                </div>
            </div>

            <div class="account-info-item">
                <div class="account-info-icon">🛡️</div>
                <div class="account-info-content">
                    <span>Hak Akses</span>
                    <strong>Administrator</strong>
                </div>
            </div>

        </div>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST" class="account-actions">
            @csrf

            <button type="submit" class="logout-button">
                <span>↪</span>
                Logout
            </button>
        </form>

    </div>

</div>

<style>

/* =====================================
   TENTANG AKUN - SINKRON DENGAN TEMA
===================================== */

.account-page {
    --account-panel: var(--card-bg, var(--surface-color, #ffffff));
    --account-panel-light: var(--surface-color, var(--card-bg, #f8fafc));
    --account-border: var(--border-color, #e2e8f0);
    --account-text: var(--text-color, var(--text-primary, #172033));
    --account-muted: var(--muted-color, var(--text-secondary, #64748b));
    --account-blue: #3478f6;

    width: 100%;
    min-width: 0;
    color: var(--account-text);
}

.account-page,
.account-page * {
    box-sizing: border-box;
}

/* Header */

.account-page .account-page-header {
    margin-bottom: 22px;
}

.account-page .account-page-header h1 {
    margin: 0 0 7px;
    color: var(--account-text);
    font-size: 24px;
    font-weight: 750;
}

.account-page .account-page-header p {
    margin: 0;
    color: var(--account-muted);
    font-size: 14px;
    line-height: 1.7;
}

/* Kartu utama */

.account-page .account-card {
    position: relative;
    max-width: 650px;
    padding: 32px;
    overflow: hidden;
    background: var(--account-panel);
    color: var(--account-text);
    border: 1px solid var(--account-border);
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.10);
}

.account-page .account-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3478f6, #78b4ff);
}

/* Avatar */

.account-page .account-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 82px;
    height: 82px;
    margin: 0 auto 16px;
    border: 3px solid #5689d8;
    border-radius: 50%;
    background: linear-gradient(145deg, #4388ff, #2455c7);
    color: #ffffff;
    font-size: 25px;
    font-weight: 800;
    box-shadow: 0 6px 20px rgba(52, 120, 246, 0.22);
}

.account-page .account-card h2 {
    margin: 0 0 7px;
    color: var(--account-text);
    font-size: 23px;
    font-weight: 750;
    overflow-wrap: anywhere;
}

.account-page .account-role {
    margin: 0 0 15px;
    color: var(--account-muted);
    font-size: 14px;
    line-height: 1.6;
}

/* Badge akun */

.account-page .account-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 13px;
    margin-bottom: 26px;
    border: 1px solid var(--account-border);
    border-radius: 30px;
    background: var(--account-panel-light);
    color: var(--account-text);
    font-size: 12px;
    font-weight: 650;
}

.account-page .account-status-dot {
    width: 7px;
    height: 7px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #22c55e;
}

/* Detail informasi */

.account-page .account-info {
    margin-bottom: 24px;
    overflow: hidden;
    border: 1px solid var(--account-border);
    border-radius: 12px;
    text-align: left;
}

.account-page .account-info-item {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
    padding: 17px;
    background: var(--account-panel-light);
    color: var(--account-text);
    border-bottom: 1px solid var(--account-border);
}

.account-page .account-info-item:last-child {
    border-bottom: 0;
}

.account-page .account-info-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    border: 1px solid var(--account-border);
    border-radius: 10px;
    background: var(--account-panel);
    font-size: 16px;
}

.account-page .account-info-content {
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 0;
}

.account-page .account-info-content span {
    color: var(--account-muted);
    font-size: 12px;
}

.account-page .account-info-content strong {
    color: var(--account-text);
    font-size: 14px;
    font-weight: 650;
    overflow-wrap: anywhere;
}

/* Tombol logout */

.account-page .account-actions {
    display: flex;
    justify-content: center;
    margin: 0;
}

.account-page .logout-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 9px;
    min-width: 145px;
    padding: 12px 22px;
    border: 1px solid #dc3545;
    border-radius: 9px;
    background: #dc3545;
    color: #ffffff;
    font-family: inherit;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s ease, transform 0.2s ease;
}

.account-page .logout-button:hover {
    background: #bb2d3b;
    border-color: #bb2d3b;
    transform: translateY(-1px);
}

.account-page .logout-button span {
    font-size: 18px;
}

/* Mode gelap: dukung beberapa penanda tema umum */

:is(
    .dark,
    .dark-mode,
    body.dark,
    [data-theme="dark"],
    [data-bs-theme="dark"]
) .account-page {
    --account-panel: var(--card-bg, var(--surface-color, #172438));
    --account-panel-light: var(--surface-color, var(--card-bg, #19283e));
    --account-border: var(--border-color, #293b55);
    --account-text: var(--text-color, var(--text-primary, #edf3ff));
    --account-muted: var(--muted-color, var(--text-secondary, #a9bddb));
}

/* Tampilan HP */

@media (max-width: 600px) {
    .account-page .account-card {
        padding: 24px 17px;
        border-radius: 13px;
    }

    .account-page .account-page-header h1 {
        font-size: 21px;
    }

    .account-page .account-avatar {
        width: 72px;
        height: 72px;
        font-size: 22px;
    }

    .account-page .account-card h2 {
        font-size: 21px;
    }

    .account-page .account-info-item {
        padding: 14px;
        gap: 11px;
    }
}


</style>

@endsection