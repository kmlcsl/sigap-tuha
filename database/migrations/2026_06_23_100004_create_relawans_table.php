<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained('organisasi_relawans')->cascadeOnDelete();
            $table->string('nama_lengkap', 150);
            $table->string('jabatan', 100)->nullable();
            $table->string('keahlian', 200)->nullable();
            $table->string('nomor_hp', 20)->nullable();
            $table->string('nomor_wa', 20)->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relawans');
    }
};
