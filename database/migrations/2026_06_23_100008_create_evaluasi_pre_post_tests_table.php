<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi_pre_post_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edukasi_id')->nullable()->constrained('edukasis')->nullOnDelete();
            $table->string('nama_pelatihan', 200);
            $table->string('nama_peserta', 150);
            $table->date('tanggal');
            $table->integer('nilai_pre_test');
            $table->integer('nilai_post_test')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_pre_post_tests');
    }
};
