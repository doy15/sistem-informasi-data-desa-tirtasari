
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tps', function (Blueprint $table) {
            $table->foreignId('pemilihan_id')
                ->default(1)
                ->constrained('pemilihan')
                ->cascadeOnDelete();

            $table->unsignedInteger('nomor')->default(1);

            $table->unique(['pemilihan_id', 'nomor']);
        });
    }

    public function down(): void
    {
        Schema::table('tps', function (Blueprint $table) {
            $table->dropUnique(['pemilihan_id', 'nomor']);
            $table->dropConstrainedForeignId('pemilihan_id');
            $table->dropColumn('nomor');
        });
    }
};
