<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rts', function (Blueprint $table) {
            $table->foreignId('dusun_id')
                ->nullable()
                ->after('rw_id')
                ->constrained('dusuns')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dusun_id');
        });
    }
};
