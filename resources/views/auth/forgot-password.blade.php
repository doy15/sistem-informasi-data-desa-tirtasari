<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Desa Tirtasari</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: Arial, sans-serif;
            background: #eef3f8;
            color: #19324d;
        }
        .card {
            width: 100%;
            max-width: 460px;
            padding: 36px;
            background: white;
            border: 1px solid #d5e0eb;
            border-radius: 18px;
            box-shadow: 0 12px 35px #19324d12;
        }
        h1 { font-size: 28px; margin-top: 0; }
        p { line-height: 1.6; color: #53677c; }
        label { display: block; font-weight: bold; margin: 24px 0 8px; }
        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #aebfd0;
            border-radius: 9px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 15px;
            margin-top: 18px;
            border: 0;
            border-radius: 9px;
            background: #185abd;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        a { color: #185abd; }
        .message { padding: 12px; background: #edf8f0; border-radius: 8px; }
        .error { color: #b42318; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Lupa Password?</h1>
        <p>Masukkan email akunmu. Kami akan mengirimkan tautan untuk membuat password baru.</p>

        @if (session('status'))
            <p class="message">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">Alamat email akun</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
                autofocus
            >
            <button type="submit">Kirim Tautan Reset</button>
        </form>

        <p><a href="{{ route('login') }}">Kembali ke halaman login</a></p>
    </main>
</body>
</html>
