
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tps', 'pemilihan_id')) {
            Schema::table('tps', function (Blueprint $table) {
                $table->foreignId('pemilihan_id')
                    ->nullable()
                    ->constrained('pemilihan')
                    ->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('tps', 'nomor')) {
            Schema::table('tps', function (Blueprint $table) {
                $table->unsignedInteger('nomor')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Sengaja tidak menghapus kolom agar data tetap aman.
    }
};
