<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DPS TPS {{ $tps->nomor }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }
        h2, p { text-align: center; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #333; padding: 5px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>DAFTAR PEMILIH TPS {{ $tps->nomor }}</h2>
    <p>{{ $pemilihan->nama }}</p>
    <p>Tanggal pemilihan:
        {{ $pemilihan->tanggal_pemilihan?->format('d-m-Y') }}
    </p>
    <p>Total calon pemilih: {{ $penduduks->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Umur</th>
                <th>RT</th>
                <th>Nomor KK</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penduduks as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->jenis_kelamin ?? '-' }}</td>
                    <td>{{ $p->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $p->umur_pada_pemilihan }}</td>
                    <td>{{ $p->kartuKeluarga?->rt?->nomor ?? '-' }}</td>
                    <td>{{ $p->kartuKeluarga?->no_kk ?? '-' }}</td>
                    <td>{{ $p->kartuKeluarga?->alamat ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
