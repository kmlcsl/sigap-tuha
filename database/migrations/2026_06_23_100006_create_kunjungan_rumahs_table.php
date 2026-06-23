<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_rumahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lansia', 150);
            $table->foreignId('lansia_id')->nullable()->constrained('lansias')->nullOnDelete();
            $table->string('nama_relawan', 150);
            $table->date('tanggal_kunjungan');
            $table->enum('kondisi_fisik', ['Baik', 'Cukup', 'Buruk']);
            $table->enum('kondisi_psikologis', ['Stabil', 'Perlu Pendampingan', 'Krisis']);
            $table->text('catatan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_rumahs');
    }
};
