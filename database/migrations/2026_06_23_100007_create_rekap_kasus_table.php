<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_kasus', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kasus', ['Kesehatan', 'Bantuan Sosial', 'Psikologis', 'Evakuasi', 'Lainnya']);
            $table->text('deskripsi_kasus');
            $table->string('nama_lansia', 150)->nullable();
            $table->date('tanggal_kejadian');
            $table->enum('status_penanganan', ['Ditangani', 'Dalam Proses', 'Belum Ditangani'])->default('Belum Ditangani');
            $table->text('penanganan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_kasus');
    }
};
