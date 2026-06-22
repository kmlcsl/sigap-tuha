<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;

use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\EdukasiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PetaController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;

Route::get('/', [HomeController::class, 'index'])->name('beranda');

// Secret Login Route
Route::get('/sigap-admin-secret', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/sigap-admin-secret', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('features', FeatureController::class);
    Route::resource('lansia', LansiaController::class);
    Route::resource('laporan', LaporanController::class);
    Route::resource('edukasi', EdukasiController::class);
    Route::resource('users', UserController::class);
    Route::resource('programs', AdminProgramController::class);
    Route::resource('programs.kegiatans', AdminKegiatanController::class)->except(['index', 'show']);
    Route::get('profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('profil.index');
    Route::post('profil', [App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('profil.update');
    
    Route::get('kontak', [App\Http\Controllers\Admin\KontakController::class, 'index'])->name('kontak.index');
    Route::post('kontak', [App\Http\Controllers\Admin\KontakController::class, 'update'])->name('kontak.update');
    
    Route::resource('berita', App\Http\Controllers\Admin\BeritaController::class);
    
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::get('peta', [PetaController::class, 'index'])->name('peta.index');
});

Route::get('/profil', [HomeController::class, 'profil'])->name('profil');

Route::get('/program', [ProgramController::class, 'index'])->name('program');
Route::get('/program/{id}/kegiatan', [ProgramController::class, 'getKegiatan']);

Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('berita.detail');

Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

Route::get('/{slug}', [HomeController::class, 'fitur'])->name('fitur.detail');
