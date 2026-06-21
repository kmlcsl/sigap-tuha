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
        Schema::create('lansias', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->integer('umur');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('desa', 100);
            $table->string('kontak_keluarga', 20)->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->string('kondisi_kesehatan', 100)->nullable();
            $table->enum('status', ['Stabil', 'Perlu pemantauan', 'Rujukan segera'])->default('Stabil');
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lansias');
    }
};
