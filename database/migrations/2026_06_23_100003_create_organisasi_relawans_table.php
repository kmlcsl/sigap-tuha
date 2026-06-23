<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisasi_relawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_organisasi', 200);
            $table->string('singkatan', 20)->nullable();
            $table->text('deskripsi');
            $table->string('kontak_wa', 20)->nullable();
            $table->string('kontak_telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('bidang_keahlian', 200)->nullable();
            $table->string('warna_tema', 10)->nullable()->default('#0d9488');
            $table->text('alamat')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisasi_relawans');
    }
};
