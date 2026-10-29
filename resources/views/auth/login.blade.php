
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Login Admin — Desa Tirtasari</title>

    <script>
        (() => {
            let savedTheme = null;

            try {
                savedTheme = localStorage.getItem('login-theme');
            } catch (error) {}

            const deviceDark = window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches;

            document.documentElement.dataset.theme =
                savedTheme === 'dark' || savedTheme === 'light'
                    ? savedTheme
                    : deviceDark ? 'dark' : 'light';
        })();
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            color-scheme: light;
            --bg: #edf2f8;
            --text: #172b4d;
            --muted: #61728a;
            --card: rgba(255, 255, 255, .68);
            --card-border: rgba(255, 255, 255, .85);
            --input: rgba(255, 255, 255, .65);
            --input-border: #cbd6e5;
            --blue: #246bfd;
            --focus: rgba(36, 107, 253, .18);
            --error-bg: rgba(220, 38, 38, .08);
            --error: #b42318;
            --shadow: 0 24px 70px rgba(38, 61, 95, .15);
        }

        html[data-theme="dark"] {
            color-scheme: dark;
            --bg: #0b1220;
            --text: #edf4ff;
            --muted: #a5b4ca;
            --card: rgba(22, 33, 52, .78);
            --card-border: rgba(197, 213, 235, .17);
            --input: rgba(7, 15, 29, .65);
            --input-border: #394961;
            --blue: #5592ff;
            --focus: rgba(85, 146, 255, .22);
            --error-bg: rgba(248, 113, 113, .1);
            --error: #fca5a5;
            --shadow: 0 24px 70px rgba(0, 0, 0, .3);
        }

        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            overflow-x: hidden;
            position: relative;
            isolation: isolate;
            background:
                radial-gradient(
                    ellipse at 12% 15%,
                    rgba(93, 157, 255, .19),
                    transparent 38%
                ),
                radial-gradient(
                    ellipse at 90% 85%,
                    rgba(148, 163, 184, .22),
                    transparent 36%
                ),
                var(--bg);
            color: var(--text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            font-size: 16px;
            transition: background .25s, color .25s;
        }

        html[data-theme="dark"] body {
            background:
                radial-gradient(
                    ellipse at 12% 15%,
                    rgba(37, 99, 235, .25),
                    transparent 38%
                ),
                radial-gradient(
                    ellipse at 90% 85%,
                    rgba(100, 116, 139, .15),
                    transparent 36%
                ),
                var(--bg);
        }

        .orb {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            filter: blur(2px);
            pointer-events: none;
        }

        .orb-one {
            width: 240px;
            height: 240px;
            top: 7%;
            left: -75px;
            background: linear-gradient(
                135deg,
                rgba(96, 165, 250, .45),
                rgba(203, 213, 225, .12)
            );
        }

        .orb-two {
            width: 300px;
            height: 300px;
            right: -110px;
            bottom: 3%;
            background: linear-gradient(
                135deg,
                rgba(37, 99, 235, .25),
                rgba(203, 213, 225, .12)
            );
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 38px;
            position: relative;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            box-shadow: var(--shadow);
            -webkit-backdrop-filter: blur(24px);
            backdrop-filter: blur(24px);
            animation: cardAppear .55s ease both;
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .brand {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 18px;
            background: linear-gradient(145deg, #448aff, #1555db);
            color: #fff;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -1px;
            box-shadow: 0 9px 24px rgba(36, 107, 253, .28);
        }

        .theme-controls {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .theme-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .theme-switch {
            position: relative;
            width: 48px;
            height: 28px;
            flex-shrink: 0;
            padding: 0;
            border: 1px solid var(--input-border);
            border-radius: 999px;
            background: var(--input);
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }

        .switch-knob {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--blue);
            color: #fff;
            font-size: 12px;
            line-height: 1;
            transition: transform .22s ease;
        }

        .theme-switch[aria-checked="true"] .switch-knob {
            transform: translateX(20px);
        }

        h1 {
            margin: 0 0 10px;
            font-size: clamp(27px, 5vw, 32px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .subtitle {
            margin: 0 0 30px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .field {
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            font-size: 13px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap input {
            width: 100%;
            min-height: 51px;
            padding: 14px 15px;
            border: 1px solid var(--input-border);
            border-radius: 13px;
            outline: none;
            background: var(--input);
            color: var(--text);
            font: inherit;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-wrap input::placeholder {
            color: var(--muted);
            opacity: .8;
        }

        .input-wrap input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px var(--focus);
        }

        .password-input {
            padding-right: 82px !important;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 9px;
            transform: translateY(-50%);
            width: auto;
            padding: 7px 8px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--blue);
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .toggle-password:hover {
            background: var(--focus);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 4px 0 24px;
            color: var(--muted);
            font-size: 13px;
            cursor: pointer;
        }

        .remember input {
            width: 17px;
            height: 17px;
            margin: 0;
            accent-color: var(--blue);
            cursor: pointer;
        }

        .submit-button {
            width: 100%;
            min-height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            border: 0;
            border-radius: 13px;
            background: linear-gradient(110deg, #3985ff, #245ce8);
            color: #fff;
            font: inherit;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(36, 107, 253, .23);
            transition: transform .2s, box-shadow .2s, filter .2s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(36, 107, 253, .3);
            filter: brightness(1.05);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .forgot {
            display: block;
            margin-top: 21px;
            text-align: center;
            color: var(--blue);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .forgot:hover,
        .back:hover {
            text-decoration: underline;
        }

        .error {
            margin-top: 8px;
            padding: 10px 12px;
            border: 1px solid var(--error-bg);
            border-radius: 10px;
            background: var(--error-bg);
            color: var(--error);
            font-size: 12px;
            line-height: 1.5;
        }

        .footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--card-border);
            text-align: center;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .back {
            display: block;
            width: fit-content;
            margin: 19px auto 0;
            color: var(--muted);
            font-size: 12px;
            text-decoration: none;
        }

        button:focus-visible,
        a:focus-visible {
            outline: 3px solid var(--blue);
            outline-offset: 4px;
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 14px;
            }

            .login-card {
                padding: 28px 22px;
                border-radius: 23px;
            }

            .card-top {
                margin-bottom: 25px;
            }

            .orb-one {
                width: 170px;
                height: 170px;
            }

            .orb-two {
                width: 210px;
                height: 210px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="orb orb-one" aria-hidden="true"></div>
    <div class="orb orb-two" aria-hidden="true"></div>

    <main class="login-card">
        <div class="card-top">
            <div class="brand" aria-label="Desa Tirtasari">DT</div>

            <div class="theme-controls">
                <span class="theme-label" id="themeLabel">Terang</span>

                <button
                    class="theme-switch"
                    id="themeSwitch"
                    type="button"
                    role="switch"
                    aria-checked="false"
                    aria-label="Aktifkan mode gelap"
                >
                    <span class="switch-knob" id="themeIcon" aria-hidden="true">☀</span>
                </button>
            </div>
        </div>

        <h1>Selamat Datang</h1>

        <p class="subtitle">
            Login ke panel administrasi<br>
            <strong>Sistem Informasi Desa Tirtasari</strong><br>
            Kecamatan Tirtamulya, Kabupaten Karawang
        </p>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="field">
                <label for="email">Email admin</label>

                <div class="input-wrap">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                @error('email')
                    <div class="error" role="alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>

                <div class="input-wrap">
                    <input
                        class="password-input"
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        class="toggle-password"
                        id="togglePassword"
                        type="button"
                        aria-controls="password"
                        aria-label="Tampilkan password"
                        aria-pressed="false"
                    >
                        Lihat
                    </button>
                </div>

                @error('password')
                    <div class="error" role="alert">{{ $message }}</div>
                @enderror
            </div>

            <label class="remember" for="remember">
                <input
                    id="remember"
                    type="checkbox"
                    name="remember"
                    value="1"
                    @checked(old('remember'))
                >
                Ingat saya
            </label>

            <button class="submit-button" type="submit">
                Masuk ke Dashboard
                <span aria-hidden="true">→</span>
            </button>
        </form>

        <a class="forgot" href="{{ route('password.request') }}">
            Lupa password?
        </a>

        <div class="footer">
            © {{ date('Y') }} Pemerintah Desa Tirtasari<br>
            Sistem Informasi Administrasi Desa
        </div>

        <a class="back" href="/">← Kembali ke halaman utama</a>
    </main>

    <script>
        // Switch tema terang dan gelap.
        const colorScheme = window.matchMedia(
            '(prefers-color-scheme: dark)'
        );

        const themeSwitch = document.getElementById('themeSwitch');
        const themeLabel = document.getElementById('themeLabel');
        const themeIcon = document.getElementById('themeIcon');

        function getSavedTheme() {
            try {
                return localStorage.getItem('login-theme');
            } catch (error) {
                return null;
            }
        }

        function saveTheme(theme) {
            try {
                localStorage.setItem('login-theme', theme);
            } catch (error) {
                // Tema tetap berfungsi untuk halaman saat ini.
            }
        }

        function applyTheme(theme) {
            document.documentElement.dataset.theme = theme;

            const isDark = theme === 'dark';

            themeSwitch.setAttribute('aria-checked', String(isDark));
            themeSwitch.setAttribute(
                'aria-label',
                isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap'
            );

            themeLabel.textContent = isDark ? 'Gelap' : 'Terang';
            themeIcon.textContent = isDark ? '☾' : '☀';
        }

        function handleDeviceThemeChange(event) {
            const savedTheme = getSavedTheme();

            // Ikuti perangkat hanya jika belum ada pilihan manual.
            if (savedTheme !== 'light' && savedTheme !== 'dark') {
                applyTheme(event.matches ? 'dark' : 'light');
            }
        }

        applyTheme(
            getSavedTheme() === 'dark' || getSavedTheme() === 'light'
                ? getSavedTheme()
                : colorScheme.matches ? 'dark' : 'light'
        );

        themeSwitch.addEventListener('click', function () {
            const currentTheme =
                document.documentElement.dataset.theme;

            const nextTheme =
                currentTheme === 'dark' ? 'light' : 'dark';

            applyTheme(nextTheme);
            saveTheme(nextTheme);
        });

        if (typeof colorScheme.addEventListener === 'function') {
            colorScheme.addEventListener('change', handleDeviceThemeChange);
        } else {
            colorScheme.addListener(handleDeviceThemeChange);
        }

        // Tampilkan atau sembunyikan password.
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const showPassword = passwordInput.type === 'password';

            passwordInput.type = showPassword ? 'text' : 'password';
            togglePassword.textContent = showPassword ? 'Sembunyi' : 'Lihat';

            togglePassword.setAttribute(
                'aria-label',
                showPassword
                    ? 'Sembunyikan password'
                    : 'Tampilkan password'
            );

            togglePassword.setAttribute(
                'aria-pressed',
                String(showPassword)
            );
        });
    </script>
</body>
</html>
