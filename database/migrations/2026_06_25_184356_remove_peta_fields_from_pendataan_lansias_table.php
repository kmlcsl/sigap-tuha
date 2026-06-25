<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendataan_lansias', function (Blueprint $table) {
            $table->dropColumn([
                'keterangan_usia_70_plus',
                'latitude',
                'longitude',
                'penyakit_bawaan'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('pendataan_lansias', function (Blueprint $table) {
            $table->text('keterangan_usia_70_plus')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('penyakit_bawaan')->nullable();
        });
    }
};
