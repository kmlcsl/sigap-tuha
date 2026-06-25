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
        Schema::table('pendataan_lansias', function (Blueprint $table) {
            $table->renameColumn('kecamatan', 'desa');
            
            $table->text('keterangan_usia_70_plus')->nullable()->after('usia_70_plus_p');
            $table->string('latitude')->nullable()->after('keterangan_usia_70_plus');
            $table->string('longitude')->nullable()->after('latitude');
            $table->text('penyakit_bawaan')->nullable()->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendataan_lansias', function (Blueprint $table) {
            $table->dropColumn(['keterangan_usia_70_plus', 'latitude', 'longitude', 'penyakit_bawaan']);
            $table->renameColumn('desa', 'kecamatan');
        });
    }
};
