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
        Schema::create('jawaban_soal_monevs', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_monev');
            $table->enum('jenis_test', ['PRE', 'POST']);
            $table->unsignedBigInteger('id_soal');
            $table->enum('pilihan_jawaban', ['SS', 'S', 'N', 'TS', 'STS']);
            $table->timestamps();

            $table->foreign('id_monev')->references('id_monev')->on('kegiatan_monevs')->onDelete('cascade');
            $table->foreign('id_soal')->references('id_soal')->on('master_soal_monevs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_soal_monevs');
    }
};
