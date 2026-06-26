<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\Admin\LansiaController as AdminLansiaController;
use App\Http\Controllers\Admin\EdukasiController as AdminEdukasiController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\PetaController as AdminPetaController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\KontakController as AdminKontakController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\BantuanDaruratController as AdminBantuanDaruratController;
use App\Http\Controllers\Admin\OrganisasiRelawanController as AdminOrganisasiRelawanController;
use App\Http\Controllers\Admin\MonitoringController as AdminMonitoringController;

Route::get('/', [HomeController::class, 'index'])->name('beranda');

// Secret Login Route
Route::get('/sigap-admin-secret', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/sigap-admin-secret', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('features', AdminFeatureController::class);

    // CARD 1: LANSIA
    Route::get('lansia/export', [AdminLansiaController::class, 'export'])->name('lansia.export');
    Route::resource('lansia', AdminLansiaController::class)->parameters(['lansia' => 'lansia']);

    // CARD 2: BANTUAN DARURAT
    Route::resource('bantuan-darurat', AdminBantuanDaruratController::class);
    Route::patch('bantuan-darurat/{bantuan_darurat}/toggle', [AdminBantuanDaruratController::class, 'toggleActive'])->name('bantuan-darurat.toggle');

    // CARD 3: EDUKASI & PELATIHAN
    Route::resource('edukasi', AdminEdukasiController::class);

    // CARD 4: RELAWAN SIAGA
    Route::resource('organisasi-relawan', AdminOrganisasiRelawanController::class);

    // CARD 5: MONITORING
    Route::prefix('monitoring')->name('monitoring.')->group(function () {
        Route::get('/', [AdminMonitoringController::class, 'index'])->name('index');
        
        Route::get('/kegiatan', [AdminMonitoringController::class, 'kegiatanIndex'])->name('kegiatan.index');
        Route::post('/kegiatan', [AdminMonitoringController::class, 'kegiatanStore'])->name('kegiatan.store');
        Route::put('/kegiatan/{id}', [AdminMonitoringController::class, 'kegiatanUpdate'])->name('kegiatan.update');
        Route::delete('/kegiatan/{id}', [AdminMonitoringController::class, 'kegiatanDestroy'])->name('kegiatan.destroy');

        Route::get('/kegiatan/{id_kegiatan}/soal', [AdminMonitoringController::class, 'soalPerKegiatan'])->name('kegiatan.soal');
        Route::post('/soal', [AdminMonitoringController::class, 'soalStore'])->name('soal.store');
        Route::put('/soal/{id}', [AdminMonitoringController::class, 'soalUpdate'])->name('soal.update');
        Route::delete('/soal/{id}', [AdminMonitoringController::class, 'soalDestroy'])->name('soal.destroy');
        Route::get('/{monev}', [AdminMonitoringController::class, 'show'])->name('show');
        Route::delete('/{monev}', [AdminMonitoringController::class, 'destroy'])->name('destroy');
    });

    Route::resource('users', AdminUserController::class);
    Route::resource('programs', AdminProgramController::class);
    Route::resource('programs.kegiatans', AdminKegiatanController::class)->except(['index', 'show']);
    Route::get('profil', [AdminProfilController::class, 'index'])->name('profil.index');
    Route::post('profil', [AdminProfilController::class, 'update'])->name('profil.update');
    
    Route::get('kontak', [AdminKontakController::class, 'index'])->name('kontak.index');
    Route::post('kontak', [AdminKontakController::class, 'update'])->name('kontak.update');
    
    Route::resource('berita', AdminBeritaController::class);
    
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings');
    Route::get('peta', [AdminPetaController::class, 'index'])->name('peta.index');
});

Route::get('/profil', [HomeController::class, 'profil'])->name('profil');

Route::get('/program', [ProgramController::class, 'index'])->name('program');
Route::get('/program/{id}/kegiatan', [ProgramController::class, 'getKegiatan']);

Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('berita.detail');

Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// PUBLIC ROUTES: 5 CARD UTAMA
Route::get('/pendataan-lansia', [HomeController::class, 'lansia'])->name('lansia');
Route::get('/bantuan-darurat', [HomeController::class, 'bantuanDarurat'])->name('bantuan');
Route::get('/edukasi-pelatihan', [HomeController::class, 'edukasi'])->name('edukasi');
Route::get('/edukasi-pelatihan/{id}', [HomeController::class, 'edukasiDetail'])->name('edukasi.detail');
Route::get('/relawan-siaga', [HomeController::class, 'relawan'])->name('relawan');

// PUBLIC ROUTES: MONEV
Route::get('/monitoring-evaluasi', [AdminMonitoringController::class, 'publicIndex'])->name('monev.index');
Route::post('/monitoring-evaluasi/pre-test', [AdminMonitoringController::class, 'storePreTest'])->name('monev.store_pre_test');
Route::post('/monitoring-evaluasi/post-test', [AdminMonitoringController::class, 'storePostTest'])->name('monev.store_post_test');

Route::get('/{slug}', [HomeController::class, 'fitur'])->name('fitur.detail');
