<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');

    // Kartu Keluarga (resource-style)
    Route::get('manajemenWarga',                          [WargaController::class, 'index'])  ->name('warga.index');
    Route::get('manajemenWarga/create',                   [WargaController::class, 'create']) ->name('warga.create');
    Route::post('manajemenWarga',                         [WargaController::class, 'store'])  ->name('warga.store');
    Route::get('manajemenWarga/{kartuKeluarga}',          [WargaController::class, 'show'])   ->name('warga.show');
    Route::get('manajemenWarga/{kartuKeluarga}/edit',     [WargaController::class, 'edit'])   ->name('warga.edit');
    Route::put('manajemenWarga/{kartuKeluarga}',          [WargaController::class, 'update']) ->name('warga.update');
    Route::delete('manajemenWarga/{kartuKeluarga}',       [WargaController::class, 'destroy'])->name('warga.destroy');

    // Anggota Keluarga
    Route::get('manajemenWarga/{kartuKeluarga}/anggota/create', [WargaController::class, 'createAnggota'])->name('warga.anggota.create');
    Route::post('manajemenWarga/{kartuKeluarga}/anggota',       [WargaController::class, 'storeAnggota']) ->name('warga.anggota.store');
    Route::get('anggota/{anggota}/edit',                        [WargaController::class, 'editAnggota'])  ->name('warga.anggota.edit');
    Route::put('anggota/{anggota}',                             [WargaController::class, 'updateAnggota'])->name('warga.anggota.update');
    Route::delete('anggota/{anggota}',                          [WargaController::class, 'destroyAnggota'])->name('warga.anggota.destroy');
});

// Route Warga
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'wargaIndex'])->name('dashboard');
    Route::get('/data-saya', [WargaController::class, 'dataSaya'])->name('data-saya');
});