
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Pemilihan;

use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\DataPemilihController;
use App\Http\Controllers\PemilihanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TpsDpsController;

/*
|--------------------------------------------------------------------------
| Landing page publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('home');

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->query('email'),
        ]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard dan halaman admin
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard harus menampilkan resources/views/dashboard.blade.php
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/tentang-akun', function () {
        return view('tentang-akun');
    })->name('tentang-akun');

    /*
    |--------------------------------------------------------------------------
    | Penduduk
    |--------------------------------------------------------------------------
    */

    Route::get('/penduduk', function (Request $request) {
        $query = Penduduk::with('kartuKeluarga.rt.rw.dusun');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhereHas('kartuKeluarga', function ($kk) use ($search) {
                        $kk->where('no_kk', 'like', "%{$search}%")
                            ->orWhere('alamat', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $jenisKelamin = strtoupper(trim(
                $request->input('jenis_kelamin')
            ));

            if (in_array($jenisKelamin, ['LAKI-LAKI', 'PEREMPUAN'])) {
                $query->whereRaw(
                    'UPPER(TRIM(jenis_kelamin)) = ?',
                    [$jenisKelamin]
                );
            }
        }

        $penduduks = $query->orderBy('nama_lengkap')->get();

        $pemilihan = Pemilihan::with('tps.rts')
            ->latest('id')
            ->first();

        $rtKeTps = [];

        if ($pemilihan) {
            foreach ($pemilihan->tps as $tps) {
                foreach ($tps->rts as $rt) {
                    $rtKeTps[$rt->id] = $tps->nomor;
                }
            }
        }

        return view('penduduk.index', [
            'penduduks' => $penduduks,
            'rtKeTps' => $rtKeTps,
        ]);
    })->name('penduduk.index');

    Route::get('/penduduk/tambah', [
        PendudukController::class, 'create',
    ])->name('penduduk.create');

    Route::post('/penduduk', [
        PendudukController::class, 'store',
    ])->name('penduduk.store');

    Route::get('/penduduk/{id}/edit', [
        PendudukController::class, 'edit',
    ])->name('penduduk.edit');

    Route::put('/penduduk/{id}', [
        PendudukController::class, 'update',
    ])->name('penduduk.update');

    /*
    |--------------------------------------------------------------------------
    | Kartu keluarga
    |--------------------------------------------------------------------------
    */

    Route::get('/keluarga', function () {
        $kartuKeluargas = KartuKeluarga::with([
            'rt.rw.dusun',
            'penduduks',
        ])->orderBy('no_kk')->get();

        return view('keluarga.index', [
            'kartuKeluargas' => $kartuKeluargas,
        ]);
    })->name('keluarga.index');

    Route::get('/keluarga/tambah', [
        KartuKeluargaController::class, 'create',
    ])->name('keluarga.create');

    Route::post('/keluarga', [
        KartuKeluargaController::class, 'store',
    ])->name('keluarga.store');

    Route::get('/keluarga/{id}', function ($id) {
        $kartuKeluarga = KartuKeluarga::with([
            'penduduks',
            'rt.rw.dusun',
        ])->findOrFail($id);

        return view('keluarga.show', [
            'kartuKeluarga' => $kartuKeluarga,
        ]);
    })->name('keluarga.show');

    /*
    |--------------------------------------------------------------------------
    | Wilayah
    |--------------------------------------------------------------------------
    */

    Route::get('/wilayah', [
        WilayahController::class, 'index',
    ])->name('wilayah.index');

    Route::post('/wilayah/dusun', [
        WilayahController::class, 'storeDusun',
    ])->name('wilayah.dusun.store');

    Route::put('/wilayah/dusun/{dusun}', [
        WilayahController::class, 'updateDusun',
    ])->name('wilayah.dusun.update');

    Route::delete('/wilayah/dusun/{dusun}', [
        WilayahController::class, 'destroyDusun',
    ])->name('wilayah.dusun.destroy');

    Route::post('/wilayah/rw', [
        WilayahController::class, 'storeRw',
    ])->name('wilayah.rw.store');

    Route::put('/wilayah/rw/{rw}', [
        WilayahController::class, 'updateRw',
    ])->name('wilayah.rw.update');

    Route::delete('/wilayah/rw/{rw}', [
        WilayahController::class, 'destroyRw',
    ])->name('wilayah.rw.destroy');

    Route::post('/wilayah/rt', [
        WilayahController::class, 'storeRt',
    ])->name('wilayah.rt.store');

    Route::put('/wilayah/rt/{rt}', [
        WilayahController::class, 'updateRt',
    ])->name('wilayah.rt.update');

    Route::delete('/wilayah/rt/{rt}', [
        WilayahController::class, 'destroyRt',
    ])->name('wilayah.rt.destroy');

    /*
    |--------------------------------------------------------------------------
    | Statistik
    |--------------------------------------------------------------------------
    */

    Route::get('/statistik', [
        StatistikController::class, 'index',
    ])->name('statistik.index');

    /*
    |--------------------------------------------------------------------------
    | Pengaturan
    |--------------------------------------------------------------------------
    */

    Route::get('/pengaturan', function () {
        return view('pengaturan.index');
    })
        ->middleware(\App\Http\Middleware\AdminMiddleware::class)
        ->name('pengaturan.index');
    /*
    |--------------------------------------------------------------------------
    | Data pemilih / DPS
    |--------------------------------------------------------------------------
    */

    Route::get('/data-pemilih', [
        DataPemilihController::class, 'index',
    ])->name('data-pemilih.index');

    Route::get(
        '/pemilihan/{pemilihan}/tps/{tps}/dps',
        [TpsDpsController::class, 'show']
    )->name('data-pemilih.tps.show');

    Route::get(
        '/pemilihan/{pemilihan}/tps/{tps}/dps/csv',
        [TpsDpsController::class, 'exportCsv']
    )->name('data-pemilih.tps.csv');

    Route::get(
        '/pemilihan/{pemilihan}/tps/{tps}/dps/pdf',
        [TpsDpsController::class, 'exportPdf']
    )->name('data-pemilih.tps.pdf');

    /*
    |--------------------------------------------------------------------------
    | Pemilihan dan alokasi TPS
    |--------------------------------------------------------------------------
    */

    Route::prefix('pemilihan')
        ->name('pemilihan.')
        ->controller(PemilihanController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah', 'create')->name('create');
            Route::post('/', 'store')->name('store');

            Route::post('/{pemilihan}/tps', 'storeTps')
                ->name('tps.store');

            Route::post('/{pemilihan}/tps/{tps}/rt', 'updateRt')
                ->name('tps.rt.update');

            Route::get('/{pemilihan}', 'show')->name('show');
        });
});

/*
|--------------------------------------------------------------------------
| Surat-menyurat dan pengajuan
|--------------------------------------------------------------------------
*/

Route::view('/surat-menyurat', 'surat-menyurat.index')
    ->middleware('auth')
    ->name('surat-menyurat.index');

Route::view('/pengajuan', 'pengajuan.index')
    ->middleware('auth')
    ->name('pengajuan.index');
