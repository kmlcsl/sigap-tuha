<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lansia_prioritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendataan_lansia_id')->constrained('pendataan_lansias')->cascadeOnDelete();
            $table->string('nama_lansia');
            $table->integer('umur');
            $table->string('riwayat_penyakit')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lansia_prioritas');
    }
};
