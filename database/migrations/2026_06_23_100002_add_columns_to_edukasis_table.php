<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('edukasis', function (Blueprint $table) {
            $table->text('materi_pembahasan')->nullable()->after('konten');
            $table->integer('durasi_menit')->nullable()->after('materi_pembahasan');
            $table->string('slug', 255)->nullable()->unique()->after('judul');
            $table->boolean('sertifikat_tersedia')->default(false)->after('is_published');
        });
    }
    public function down(): void {
        Schema::table('edukasis', function (Blueprint $table) {
            $table->dropColumn(['materi_pembahasan','durasi_menit','slug','sertifikat_tersedia']);
        });
    }
};
