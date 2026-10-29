
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Desa Tirtasari</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #e8edf3;
            color: #20364f;
            font-family: Arial, sans-serif;
        }

        .card {
            width: 100%;
            max-width: 460px;
            padding: 32px;
            background: white;
            border: 1px solid #d7e0ea;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(32, 54, 79, .10);
        }

        h1 { margin-top: 0; }

        p {
            color: #617187;
            line-height: 1.5;
        }

        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #bdcbd9;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 14px;
            border: 0;
            border-radius: 8px;
            background: #2477c8;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover { background: #195fa4; }

        .error {
            margin-top: 7px;
            color: #b42318;
            font-size: 14px;
        }

        .status {
            margin: 12px 0;
            color: #18794e;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #2477c8;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>Buat Password Baru</h1>
        <p>Masukkan email dan password baru untuk akun admin Desa Tirtasari.</p>

        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ url('/reset-password') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">Email admin</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $email) }}"
                required
                autocomplete="email"
            >
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password baru</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                minlength="8"
                autocomplete="new-password"
            >
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi password baru</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                minlength="8"
                autocomplete="new-password"
            >

            <button type="submit">Simpan Password Baru</button>
        </form>

        <a href="{{ route('login') }}">← Kembali ke halaman login</a>
    </main>
</body>
</html>
