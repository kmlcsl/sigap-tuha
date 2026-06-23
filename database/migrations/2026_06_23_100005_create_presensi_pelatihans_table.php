<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edukasi_id')->nullable()->constrained('edukasis')->nullOnDelete();
            $table->string('nama_pelatihan', 200);
            $table->date('tanggal');
            $table->string('nama_peserta', 150);
            $table->string('organisasi', 100)->nullable();
            $table->boolean('hadir')->default(true);
            $table->string('keterangan', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_pelatihans');
    }
};
