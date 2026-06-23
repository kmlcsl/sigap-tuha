<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bantuan_darurats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi', 200);
            $table->enum('jenis', ['Kepolisian','Damkar','Basarnas','Rumah Sakit','Puskesmas','Lainnya'])->default('Lainnya');
            $table->string('nomor_wa', 20); // format internasional tanpa +, contoh: 6281234567890
            $table->text('deskripsi')->nullable();
            $table->string('icon_class', 50)->nullable()->default('fas fa-phone-alt');
            $table->string('warna_hex', 10)->nullable()->default('#1e40af');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('bantuan_darurats');
    }
};
