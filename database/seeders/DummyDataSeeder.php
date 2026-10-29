<?php

namespace Database\Seeders;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // DUSUN NAGASARI
        // =========================

        $nagasari = Dusun::create([
            'nama' => 'Dusun Nagasari',
        ]);

        $rw07 = Rw::create([
            'dusun_id' => $nagasari->id,
            'nomor' => '07',
        ]);

        $rt14 = Rt::create([
            'rw_id' => $rw07->id,
            'nomor' => '14',
        ]);

        $rt15 = Rt::create([
            'rw_id' => $rw07->id,
            'nomor' => '15',
        ]);

        $rw08 = Rw::create([
            'dusun_id' => $nagasari->id,
            'nomor' => '08',
        ]);

        $rt16 = Rt::create([
            'rw_id' => $rw08->id,
            'nomor' => '16',
        ]);


        // =========================
        // DUSUN SUKAMAJU
        // =========================

        $sukamaju = Dusun::create([
            'nama' => 'Dusun Sukamaju',
        ]);

        $rw01 = Rw::create([
            'dusun_id' => $sukamaju->id,
            'nomor' => '01',
        ]);

        $rt01 = Rt::create([
            'rw_id' => $rw01->id,
            'nomor' => '01',
        ]);

        $rw02 = Rw::create([
            'dusun_id' => $sukamaju->id,
            'nomor' => '02',
        ]);

        $rt03 = Rt::create([
            'rw_id' => $rw02->id,
            'nomor' => '03',
        ]);


        // =========================
        // CONTOH KK 1
        // RT 14 / RW 07
        // =========================

        $kk1 = KartuKeluarga::create([
            'no_kk' => '3273000000000001',
            'alamat' => 'Kp. Nagasari',
            'rt_id' => $rt14->id,
        ]);

        Penduduk::create([
            'nik' => '3273000000000001',
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'BUDI SANTOSO',
            'status_hubungan_keluarga' => 'KEPALA KELUARGA',
            'jenis_kelamin' => 'LAKI-LAKI',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '1985-05-12',
            'golongan_darah' => 'O',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'SMA',
            'jenis_pekerjaan' => 'WIRASWASTA',
            'status_perkawinan' => 'KAWIN',
            'nama_ibu' => 'IBU BUDI',
            'nama_ayah' => 'AYAH BUDI',
            'no_paspor' => null,
            'tanggal_akhir_paspor' => null,
            'hb' => null,
        ]);

        Penduduk::create([
            'nik' => '3273000000000002',
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'SITI AMINAH',
            'status_hubungan_keluarga' => 'ISTRI',
            'jenis_kelamin' => 'PEREMPUAN',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '1988-08-20',
            'golongan_darah' => 'A',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'SMA',
            'jenis_pekerjaan' => 'IBU RUMAH TANGGA',
            'status_perkawinan' => 'KAWIN',
            'nama_ibu' => 'IBU SITI',
            'nama_ayah' => 'AYAH SITI',
            'no_paspor' => null,
            'tanggal_akhir_paspor' => null,
            'hb' => null,
        ]);

        Penduduk::create([
            'nik' => '3273000000000003',
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'ANDI SANTOSO',
            'status_hubungan_keluarga' => 'ANAK',
            'jenis_kelamin' => 'LAKI-LAKI',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '2012-03-15',
            'golongan_darah' => 'O',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'SD',
            'jenis_pekerjaan' => 'PELAJAR',
            'status_perkawinan' => 'BELUM KAWIN',
            'nama_ibu' => 'SITI AMINAH',
            'nama_ayah' => 'BUDI SANTOSO',
            'no_paspor' => null,
            'tanggal_akhir_paspor' => null,
            'hb' => null,
        ]);


        // =========================
        // CONTOH KK 2
        // RT 15 / RW 07
        // =========================

        $kk2 = KartuKeluarga::create([
            'no_kk' => '3273000000000004',
            'alamat' => 'Kp. Nagasari',
            'rt_id' => $rt15->id,
        ]);

        Penduduk::create([
            'nik' => '3273000000000004',
            'kartu_keluarga_id' => $kk2->id,
            'nama_lengkap' => 'AHMAD HIDAYAT',
            'status_hubungan_keluarga' => 'KEPALA KELUARGA',
            'jenis_kelamin' => 'LAKI-LAKI',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '1978-11-02',
            'golongan_darah' => 'B',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'SMA',
            'jenis_pekerjaan' => 'PETANI',
            'status_perkawinan' => 'KAWIN',
            'nama_ibu' => 'IBU AHMAD',
            'nama_ayah' => 'AYAH AHMAD',
        ]);

        Penduduk::create([
            'nik' => '3273000000000005',
            'kartu_keluarga_id' => $kk2->id,
            'nama_lengkap' => 'DEWI LESTARI',
            'status_hubungan_keluarga' => 'ISTRI',
            'jenis_kelamin' => 'PEREMPUAN',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '1982-02-18',
            'golongan_darah' => 'AB',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'SMA',
            'jenis_pekerjaan' => 'IBU RUMAH TANGGA',
            'status_perkawinan' => 'KAWIN',
            'nama_ibu' => 'IBU DEWI',
            'nama_ayah' => 'AYAH DEWI',
        ]);


        // =========================
        // CONTOH KK 3
        // RT 01 / RW 01
        // =========================

        $kk3 = KartuKeluarga::create([
            'no_kk' => '3273000000000006',
            'alamat' => 'Kp. Sukamaju',
            'rt_id' => $rt01->id,
        ]);

        Penduduk::create([
            'nik' => '3273000000000006',
            'kartu_keluarga_id' => $kk3->id,
            'nama_lengkap' => 'RUDI HERMAWAN',
            'status_hubungan_keluarga' => 'KEPALA KELUARGA',
            'jenis_kelamin' => 'LAKI-LAKI',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '1990-07-10',
            'golongan_darah' => 'O',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'S1',
            'jenis_pekerjaan' => 'KARYAWAN SWASTA',
            'status_perkawinan' => 'KAWIN',
            'nama_ibu' => 'IBU RUDI',
            'nama_ayah' => 'AYAH RUDI',
        ]);

        Penduduk::create([
            'nik' => '3273000000000007',
            'kartu_keluarga_id' => $kk3->id,
            'nama_lengkap' => 'LINA HERMAWATI',
            'status_hubungan_keluarga' => 'ISTRI',
            'jenis_kelamin' => 'PEREMPUAN',
            'tempat_lahir' => 'Tirtasari',
            'tanggal_lahir' => '1992-09-25',
            'golongan_darah' => 'A',
            'agama' => 'ISLAM',
            'pendidikan_akhir' => 'S1',
            'jenis_pekerjaan' => 'GURU',
            'status_perkawinan' => 'KAWIN',
            'nama_ibu' => 'IBU LINA',
            'nama_ayah' => 'AYAH LINA',
        ]);
    }
}