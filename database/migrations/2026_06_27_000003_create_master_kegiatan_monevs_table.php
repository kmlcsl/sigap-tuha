<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_kegiatan_monevs', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert 10 default questions if they don't exist
        $soals = [
            "Pemahaman tentang tujuan kegiatan.",
            "Pemahaman tentang materi dasar yang diberikan.",
            "Pemahaman tentang manfaat kegiatan bagi masyarakat.",
            "Pemahaman tentang peran serta masyarakat.",
            "Pemahaman tentang prosedur pelaksanaan kegiatan.",
            "Pemahaman tentang dampak jangka panjang kegiatan.",
            "Pemahaman tentang cara mengatasi kendala.",
            "Pemahaman tentang pengelolaan sumber daya.",
            "Pemahaman tentang evaluasi hasil kegiatan.",
            "Pemahaman keseluruhan sebelum/sesudah kegiatan."
        ];

        foreach ($soals as $index => $soal) {
            DB::table('master_soal_monevs')->updateOrInsert(
                ['urutan' => $index + 1],
                [
                    'pertanyaan' => $soal,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kegiatan_monevs');
    }
};
