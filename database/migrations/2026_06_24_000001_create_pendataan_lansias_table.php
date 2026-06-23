<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel rekap pendataan penduduk per kelompok usia per kecamatan.
     * Sesuai format file "Pendataan Lansia.xlsx".
     */
    public function up(): void
    {
        Schema::create('pendataan_lansias', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan', 150)->unique();

            // Jumlah Penduduk
            $table->unsignedInteger('jumlah_penduduk_l')->default(0);
            $table->unsignedInteger('jumlah_penduduk_p')->default(0);

            // Bayi Baru Lahir
            $table->unsignedInteger('bayi_baru_lahir_l')->default(0);
            $table->unsignedInteger('bayi_baru_lahir_p')->default(0);

            // 0 - 11 Bulan
            $table->unsignedInteger('usia_0_11_bulan_l')->default(0);
            $table->unsignedInteger('usia_0_11_bulan_p')->default(0);

            // 12 - 59 Bulan
            $table->unsignedInteger('usia_12_59_bulan_l')->default(0);
            $table->unsignedInteger('usia_12_59_bulan_p')->default(0);

            // 60 - 72 Bulan
            $table->unsignedInteger('usia_60_72_bulan_l')->default(0);
            $table->unsignedInteger('usia_60_72_bulan_p')->default(0);

            // 7 - 9 Tahun
            $table->unsignedInteger('usia_7_9_tahun_l')->default(0);
            $table->unsignedInteger('usia_7_9_tahun_p')->default(0);

            // 10 - 12 Tahun
            $table->unsignedInteger('usia_10_12_tahun_l')->default(0);
            $table->unsignedInteger('usia_10_12_tahun_p')->default(0);

            // 13 - 14 Tahun
            $table->unsignedInteger('usia_13_14_tahun_l')->default(0);
            $table->unsignedInteger('usia_13_14_tahun_p')->default(0);

            // 15 - 59 Tahun
            $table->unsignedInteger('usia_15_59_tahun_l')->default(0);
            $table->unsignedInteger('usia_15_59_tahun_p')->default(0);

            // 60 - 69 Tahun (Lansia Muda)
            $table->unsignedInteger('usia_60_69_tahun_l')->default(0);
            $table->unsignedInteger('usia_60_69_tahun_p')->default(0);

            // > 70 Tahun (Lansia Senior)
            $table->unsignedInteger('usia_70_plus_l')->default(0);
            $table->unsignedInteger('usia_70_plus_p')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendataan_lansias');
    }
};
