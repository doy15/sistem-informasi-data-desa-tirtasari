<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>@yield('title', 'Sistem Informasi Desa Tirtasari')</title>

    <script>
        (() => {
            try {
                const saved = localStorage.getItem('tirtasari-theme');
                document.documentElement.dataset.theme = saved ||
                    (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            } catch (e) {
                document.documentElement.dataset.theme = 'light';
            }
        })();
    </script>

    <style>
        .topbar-logo {
            display: block;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            object-fit: contain;
            padding: 2px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid var(--border);
        }
        :root {
            color-scheme: light;
            --brand: #2563eb;
            --sidebar: #101c33;
            --sidebar-end: #172b4d;
            --page: #f1f5f9;
            --surface: #fff;
            --surface-soft: #f8fafc;
            --text: #172033;
            --muted: #64748b;
            --border: #e2e8f0;
            --hover: #eff6ff;
            --shadow: 0 8px 28px rgba(15,23,42,.055);
            --radius: 16px;
        }

        html[data-theme="dark"] {
            color-scheme: dark;
            --page: #0d1524;
            --surface: #162235;
            --surface-soft: #1d2b40;
            --text: #e8eef8;
            --muted: #a4b3c9;
            --border: #2b3b52;
            --hover: #22344c;
            --shadow: 0 8px 26px rgba(0,0,0,.13);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--page);
            color: var(--text);
            transition: background .2s, color .2s;
        }

        button, input, select, textarea { font: inherit; }
        button, a { -webkit-tap-highlight-color: transparent; }

        .app {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: sticky;
            top: 0;
            align-self: flex-start;
            width: 258px;
            min-width: 0;
            height: 100vh;
            height: 100dvh;
            flex: 0 0 258px;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 24px 15px;
            color: #f8fafc;
            background: linear-gradient(180deg,var(--sidebar),var(--sidebar-end));
            border-right: 1px solid rgba(255,255,255,.07);
            transition: width .25s ease, flex-basis .25s ease,
                        padding .25s ease, transform .25s ease;
            z-index: 1001;
        }

        .logo {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 8px 25px;
    margin-bottom: 16px;
    min-width: 0;
    font-size: 17px;
    font-weight: 800;
    letter-spacing: .3px;
    white-space: nowrap;
}

.logo img {
    display: block;
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    object-fit: contain;
    padding: 3px;
    border-radius: 10px;
    background: rgba(255,255,255,.96);
}

.logo-brand {
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
}

.logo small {
    display: block;
    margin-top: 5px;
    color: #a9bedb;
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0;
    white-space: normal;
}

        .menu-title {
            margin: 22px 12px 9px;
            color: #8fa6c6;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 11px;
            min-height: 42px;
            margin-bottom: 5px;
            padding: 11px 13px;
            border: 1px solid transparent;
            border-radius: 11px;
            color: #d9e5f6;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
            transition: background .2s,color .2s,transform .2s;
        }

        .menu-icon {
            display: inline-flex;
            width: 20px;
            flex: 0 0 20px;
            justify-content: center;
            color: #9db7dd;
            font-size: 16px;
        }

        .menu a:hover {
            background: rgba(96,165,250,.12);
            color: #fff;
            transform: translateX(2px);
        }

        .menu a.active {
            color: #fff;
            background: linear-gradient(135deg,#2563eb,#3b82f6);
            border-color: rgba(191,219,254,.2);
            box-shadow: 0 5px 16px rgba(37,99,235,.23);
        }

        .menu a.active .menu-icon { color: #fff; }

        /* KONTEN DAN TOPBAR */
        .content {
            min-width: 0;
            flex: 1 1 auto;
            background: var(--page);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            min-height: 76px;
            padding: 12px 28px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 3px 15px rgba(15,23,42,.025);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .topbar h2 {
            overflow: hidden;
            color: var(--text);
            font-size: 20px;
            font-weight: 750;
            letter-spacing: -.4px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-toggle, .theme-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            color: var(--brand);
            font-size: 20px;
            cursor: pointer;
            transition: background .2s,border-color .2s;
        }

        .sidebar-toggle:hover, .theme-toggle:hover {
            background: var(--hover);
            border-color: #93b8ff;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* DROPDOWN AKUN */
        .user-dropdown {
            position: relative;
            flex-shrink: 0;
        }

        .user-dropdown-button {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 12px 6px 7px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--surface);
            color: var(--text);
            font-size: 13px;
            font-weight: 650;
            cursor: pointer;
        }

        .user-dropdown-button:hover,
        .user-dropdown-button[aria-expanded="true"] {
            background: var(--hover);
            border-color: #bfdbfe;
        }

        .user-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg,#2563eb,#60a5fa);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            z-index: 1100;
            display: none;
            width: 220px;
            padding: 7px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--surface);
            box-shadow: 0 16px 40px rgba(15,23,42,.16);
        }

        .user-dropdown-menu.show {
            display: block;
            animation: dropdownAppear .16s ease-out;
        }

        .user-dropdown-menu a,
        .user-dropdown-menu form button {
            display: block;
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: var(--text);
            text-align: left;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .user-dropdown-menu a:hover,
        .user-dropdown-menu form button:hover {
            background: var(--hover);
            color: var(--brand);
        }

        .user-dropdown-menu form {
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid var(--border);
        }

        .user-dropdown-menu form button { color: #ef4444; }

        @keyframes dropdownAppear {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* KONTEN HALAMAN */
        .main { padding: 28px; }

        .welcome, .card, .table-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .welcome {
            position: relative;
            overflow: hidden;
            padding: 28px;
            margin-bottom: 24px;
        }

        .welcome::before {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 5px;
            background: linear-gradient(180deg,#2563eb,#93c5fd);
            content: "";
        }

        .welcome h1 {
            margin-bottom: 8px;
            color: var(--text);
            font-size: clamp(22px,3vw,29px);
            letter-spacing: -.6px;
        }

        .welcome p { color: var(--muted); line-height: 1.7; }

        .cards {
            display: grid;
            grid-template-columns: repeat(4,minmax(0,1fr));
            gap: 18px;
        }

        .card {
            min-width: 0;
            padding: 22px;
            transition: transform .2s,box-shadow .2s;
        }

        .cards .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(15,23,42,.09);
        }

        .card .label {
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
        }

        .card .number {
            color: var(--brand);
            font-size: clamp(26px,3vw,34px);
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-header h1 { color: var(--text); font-size: 24px; }
        .page-header p { margin-top: 5px; color: var(--muted); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 17px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg,#2563eb,#3b82f6);
            color: #fff;
            font-weight: 650;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(37,99,235,.18);
            transition: transform .2s,box-shadow .2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 16px rgba(37,99,235,.24);
        }

        .table-card { overflow: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface);
        }

        th, td {
            padding: 14px 17px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            text-align: left;
            font-size: 13px;
        }

        th {
            background: var(--surface-soft);
            color: var(--muted);
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: var(--hover); }

        .empty {
            padding: 40px;
            color: var(--muted);
            text-align: center;
        }

        /* SIDEBAR COLLAPSE - DESKTOP */
        .sidebar-hidden .sidebar {
            width: 0;
            min-width: 0;
            flex-basis: 0;
            padding-left: 0;
            padding-right: 0;
            border-right: 0;
            overflow: hidden;
        }

        .sidebar-hidden .sidebar > * { visibility: hidden; }
        .sidebar-overlay { display: none; }

        /* DARK MODE */
        html[data-theme="dark"] .topbar {
            background: #131f31;
            border-bottom-color: var(--border);
        }

        html[data-theme="dark"] .welcome,
        html[data-theme="dark"] .main .card,
        html[data-theme="dark"] .table-card,
        html[data-theme="dark"] .penduduk-summary,
        html[data-theme="dark"] .search-card,
        html[data-theme="dark"] .filter-card,
        html[data-theme="dark"] .search-box,
        html[data-theme="dark"] .filter-box {
            background: var(--surface);
            color: var(--text);
            border-color: var(--border);
            box-shadow: var(--shadow);
        }

        html[data-theme="dark"] .main h1,
        html[data-theme="dark"] .main h2,
        html[data-theme="dark"] .main h3,
        html[data-theme="dark"] .topbar h2 {
            color: var(--text);
        }

        html[data-theme="dark"] .main input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]),
        html[data-theme="dark"] .main select,
        html[data-theme="dark"] .main textarea {
            background: #101b2b;
            color: #e8eef8;
            border: 1px solid #34465f;
            border-radius: 9px;
        }

        html[data-theme="dark"] .main input::placeholder,
        html[data-theme="dark"] .main textarea::placeholder {
            color: #91a2bb;
        }

        html[data-theme="dark"] .main table th {
            background: #202e43;
            color: #cbd8eb;
            border-color: #35465e;
        }

        html[data-theme="dark"] .main table td {
            background: var(--surface);
            color: #dce6f4;
            border-color: var(--border);
        }

        html[data-theme="dark"] .main table tbody tr:hover td {
            background: #203149;
        }

        html[data-theme="dark"] .card .number { color: #79a9ff; }

        html[data-theme="dark"] .sidebar-toggle,
        html[data-theme="dark"] .theme-toggle,
        html[data-theme="dark"] .user-dropdown-button {
            background: #162235;
            color: #dce8fa;
            border-color: var(--border);
        }

        html[data-theme="dark"] .user-dropdown-menu {
            background: #162235;
            border-color: var(--border);
        }

        html[data-theme="dark"] .user-dropdown-menu a,
        html[data-theme="dark"] .user-dropdown-menu form button {
            color: var(--text);
        }

        html[data-theme="dark"] .main .btn { color: #fff; }

        /* RESPONSIVE HP */
        @media (max-width: 650px) {
            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                width: 258px;
                min-width: 258px;
                height: 100vh;
                height: 100dvh;
                flex: 0 0 258px;
                padding: 24px 15px;
                overflow-x: hidden;
                overflow-y: auto;
                transform: translateX(0);
                transition: transform .25s ease;
                z-index: 1001;
            }

            .sidebar-hidden .sidebar {
                width: 258px;
                min-width: 258px;
                flex-basis: 258px;
                padding: 24px 15px;
                transform: translateX(-100%);
                border-right: 0;
            }

            .sidebar-hidden .sidebar > * { visibility: visible; }

            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1000;
                background: rgba(4,12,25,.5);
                opacity: 1;
                visibility: visible;
                transition: opacity .25s ease,visibility .25s ease;
            }

            .sidebar-hidden .sidebar-overlay {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }

            .topbar {
                min-height: 66px;
                padding: 10px 14px;
                gap: 8px;
            }

            .topbar-left { gap: 9px; }
            .topbar h2 { font-size: 16px; }
            .topbar-actions { gap: 7px; }

            .sidebar-toggle, .theme-toggle {
                width: 38px;
                height: 38px;
            }

            .user-dropdown-button {
                gap: 6px;
                padding: 4px 8px 4px 5px;
            }

            .user-avatar {
                width: 30px;
                height: 30px;
            }

            .user-name { display: none; }
            .main { padding: 16px; }
            .welcome { padding: 24px 20px; }

            .cards {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .card { padding: 20px; }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,*::before,*::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>
<div class="app sidebar-hidden" id="app">
    <aside class="sidebar" id="sidebar">
        <div class="logo">
    <img
        src="{{ asset('images/logo-karawang.png') }}"
        alt="Lambang Kabupaten Karawang"
    >

    <div class="logo-brand">
        DESA TIRTASARI
        <small>Sistem Informasi Desa</small>
    </div>
</div>

        <div class="menu-title">Menu Utama</div>
        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="menu-icon">⌂</span> Dashboard
            </a>
            <a href="{{ route('data-pemilih.index') }}" class="{{ request()->is('data-pemilih*') ? 'active' : '' }}">
                <span class="menu-icon">✓</span> Data Pemilih / DPS
            </a>
            <a href="{{ route('pemilihan.index') }}" class="{{ request()->is('pemilihan*') ? 'active' : '' }}">
                <span class="menu-icon">▤</span> Pemilihan &amp; TPS
            </a>
            <a href="{{ route('keluarga.index') }}" class="{{ request()->is('keluarga*') ? 'active' : '' }}">
                <span class="menu-icon">⌂</span> Keluarga
            </a>
            <a href="{{ route('wilayah.index') }}" class="{{ request()->is('wilayah*') ? 'active' : '' }}">
                <span class="menu-icon">◎</span> Wilayah
            </a>
        </nav>

<div class="menu-title">Pelayanan</div>
<nav class="menu">
    <a href="{{ route('surat-menyurat.index') }}"
       class="{{ request()->is('surat-menyurat*') ? 'active' : '' }}">
        <span class="menu-icon">▤</span> Surat Menyurat
    </a>

    <a href="{{ route('pengajuan.index') }}"
   class="{{ request()->is('pengajuan*') ? 'active' : '' }}">
    <span class="menu-icon">↗</span> Pengajuan
</a>
</nav>
        <div class="menu-title">Laporan</div>
        <nav class="menu">
            <a href="{{ route('statistik.index') }}" class="{{ request()->is('statistik*') ? 'active' : '' }}">
                <span class="menu-icon">▥</span> Statistik Desa
            </a>
        </nav>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <section class="content">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="sidebar-toggle" id="sidebarToggle"
                        aria-label="Buka menu" aria-expanded="false" aria-controls="sidebar">
                    ☰
                </button>
                <img
    class="topbar-logo"
    src="{{ asset('images/logo-karawang.png') }}"
    alt="Lambang Kabupaten Karawang"
>
<h2>@yield('page-title', 'Dashboard')</h2>
            </div>

            <div class="topbar-actions">
                <button type="button" class="theme-toggle" id="themeToggle"
                        aria-label="Ganti tema" title="Ganti tema">
                    <span id="themeIcon" aria-hidden="true">☾</span>
                </button>

                <div class="user-dropdown">
                    <button type="button" class="user-dropdown-button"
                            id="userDropdownButton" aria-expanded="false"
                            aria-controls="userDropdownMenu">
                        <span class="user-avatar">AD</span>
                        <span class="user-name">Admin Desa</span>
                        <span aria-hidden="true">▾</span>
                    </button>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <a href="{{ route('tentang-akun') }}">Tentang Akun</a>
                        <a href="{{ route('pengaturan.index') }}">Pengaturan</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="main">
            @yield('content')
        </main>
    </section>
</div>

<script>
(() => {
    const app = document.getElementById('app');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const userButton = document.getElementById('userDropdownButton');
    const userMenu = document.getElementById('userDropdownMenu');
    const mobileQuery = window.matchMedia('(max-width: 650px)');

    function setSidebarHidden(hidden) {
        app.classList.toggle('sidebar-hidden', hidden);

        sidebarToggle.setAttribute('aria-expanded', String(!hidden));
        sidebarToggle.setAttribute('aria-label', hidden ? 'Buka menu' : 'Tutup menu');

        document.body.style.overflow =
            mobileQuery.matches && !hidden ? 'hidden' : '';
    }

    // HP mulai tertutup, desktop mulai terbuka.
    setSidebarHidden(mobileQuery.matches);

    sidebarToggle.addEventListener('click', () => {
        setSidebarHidden(!app.classList.contains('sidebar-hidden'));
    });

    sidebarOverlay.addEventListener('click', () => setSidebarHidden(true));

    mobileQuery.addEventListener('change', event => {
        setSidebarHidden(event.matches);
    });

    function closeUserMenu() {
        userMenu.classList.remove('show');
        userButton.setAttribute('aria-expanded', 'false');
    }

    userButton.addEventListener('click', event => {
        event.stopPropagation();
        const open = userMenu.classList.toggle('show');
        userButton.setAttribute('aria-expanded', String(open));
    });

    document.addEventListener('click', event => {
        if (!userMenu.contains(event.target) && !userButton.contains(event.target)) {
            closeUserMenu();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeUserMenu();
            if (mobileQuery.matches) setSidebarHidden(true);
        }
    });

    function applyTheme(theme, save = true) {
        document.documentElement.dataset.theme = theme;
        themeIcon.textContent = theme === 'dark' ? '☀' : '☾';

        themeToggle.setAttribute(
            'aria-label',
            theme === 'dark' ? 'Aktifkan mode terang' : 'Aktifkan mode gelap'
        );
        themeToggle.title = theme === 'dark' ? 'Mode terang' : 'Mode gelap';

        if (save) {
            try {
                localStorage.setItem('tirtasari-theme', theme);
            } catch (e) {
                // Tema tetap berfungsi meski localStorage tidak tersedia.
            }
        }
    }

    applyTheme(document.documentElement.dataset.theme || 'light', false);

    themeToggle.addEventListener('click', () => {
        const current = document.documentElement.dataset.theme;
        applyTheme(current === 'dark' ? 'light' : 'dark');
    });

    document.querySelectorAll('.sidebar .menu a').forEach(link => {
        link.addEventListener('click', event => {
            const href = link.getAttribute('href');

            if (!mobileQuery.matches || !href || href === '#' ||
                link.target === '_blank' || event.ctrlKey || event.metaKey ||
                event.shiftKey || event.altKey || event.button !== 0) {
                return;
            }

            setSidebarHidden(true);
        });
    });
})();
</script>
</body>
</html>
