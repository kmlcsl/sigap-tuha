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
        Schema::table('master_soal_monevs', function (Blueprint $table) {
            // Nullable first to not break existing data
            $table->unsignedBigInteger('id_kegiatan')->nullable()->after('id_soal');
            $table->foreign('id_kegiatan')
                  ->references('id_kegiatan')
                  ->on('master_kegiatan_monevs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_soal_monevs', function (Blueprint $table) {
            $table->dropForeign(['id_kegiatan']);
            $table->dropColumn('id_kegiatan');
        });
    }
};
