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
        Schema::create('edukasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('konten');
            $table->enum('kategori', ['BHD', 'Evakuasi', 'Pertolongan Pertama', 'Lainnya'])->default('BHD');
            $table->enum('jenis', ['Artikel', 'Video', 'SOP'])->default('Artikel');
            $table->string('url_video', 500)->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edukasis');
    }
};
