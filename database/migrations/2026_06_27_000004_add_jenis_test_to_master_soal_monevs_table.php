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
            $table->enum('jenis_test', ['PRE', 'POST', 'BOTH'])->default('BOTH')->after('pertanyaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_soal_monevs', function (Blueprint $table) {
            $table->dropColumn('jenis_test');
        });
    }
};
