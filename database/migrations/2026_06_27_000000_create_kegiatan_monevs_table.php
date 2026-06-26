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
        Schema::create('kegiatan_monevs', function (Blueprint $table) {
            $table->id('id_monev');
            $table->string('nama_user');
            $table->date('tanggal_lahir');
            $table->integer('umur_user');
            $table->text('alamat_user');
            $table->string('no_hp');
            $table->string('nama_kegiatan')->nullable();
            $table->text('keterangan_kegiatan')->nullable();
            $table->text('pre_pemahaman_deskripsi')->nullable();
            $table->text('post_pemahaman_deskripsi')->nullable();
            $table->timestamp('waktu_isi_pre')->nullable();
            $table->timestamp('waktu_isi_post')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_monevs');
    }
};
