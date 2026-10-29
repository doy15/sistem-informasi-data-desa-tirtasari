<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();

            // Identitas utama
            $table->string('nik', 16)->unique();

            // Relasi ke Kartu Keluarga
            $table->foreignId('kartu_keluarga_id')
                ->nullable()
                ->constrained('kartu_keluargas')
                ->nullOnDelete();

            // Data pribadi
            $table->string('nama_lengkap');
            $table->string('status_hubungan_keluarga')->nullable();
            $table->string('jenis_kelamin', 20)->nullable();

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Data kependudukan
            $table->string('golongan_darah', 5)->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan_akhir')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->string('status_perkawinan', 50)->nullable();

            // Data orang tua
            $table->string('nama_ibu')->nullable();
            $table->string('nama_ayah')->nullable();

            // Paspor
            $table->string('no_paspor')->nullable();
            $table->date('tanggal_akhir_paspor')->nullable();

            // Field HB dari data sumber
            $table->string('hb')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};