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
        Schema::create('laporan_darurats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->cascadeOnDelete();
            $table->string('pelapor', 150);
            $table->text('kondisi');
            $table->string('lokasi', 255)->nullable();
            $table->enum('tingkat_urgensi', ['Rendah', 'Sedang', 'Tinggi', 'Kritis'])->default('Sedang');
            $table->enum('status', ['Baru', 'Diproses', 'Ditangani', 'Selesai'])->default('Baru');
            $table->text('catatan_tindakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_darurats');
    }
};
