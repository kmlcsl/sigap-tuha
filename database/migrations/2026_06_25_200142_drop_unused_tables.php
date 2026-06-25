<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('evaluasi_pre_post_tests');
        Schema::dropIfExists('rekap_kasus');
        Schema::dropIfExists('kunjungan_rumahs');
        Schema::dropIfExists('presensi_pelatihans');
        Schema::dropIfExists('laporan_darurats');
        Schema::dropIfExists('lansias');
    }

    public function down(): void
    {
        // This is a destructive migration, intentionally no rollback.
    }
};
