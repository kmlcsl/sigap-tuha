<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bantuan_darurats', function (Blueprint $table) {
            $table->dropColumn(['icon_class', 'warna_hex']);
        });

        Schema::table('organisasi_relawans', function (Blueprint $table) {
            $table->dropColumn('warna_tema');
        });
    }

    public function down(): void
    {
        Schema::table('bantuan_darurats', function (Blueprint $table) {
            $table->string('icon_class', 50)->nullable()->default('fas fa-phone-alt');
            $table->string('warna_hex', 10)->nullable()->default('#1e40af');
        });

        Schema::table('organisasi_relawans', function (Blueprint $table) {
            $table->string('warna_tema', 10)->nullable()->default('#0d9488');
        });
    }
};
