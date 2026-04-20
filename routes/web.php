<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileControlller;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\Admin\KeluhanController;

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
    Route::get('manajemenWarga/kategoriEkonomi',          [WargaController::class, 'kategoriEkonomi'])->name('warga.kategoriEkonomi');
    Route::post('manajemenWarga',                         [WargaController::class, 'store'])  ->name('warga.store');
    Route::get('manajemenWarga/semua',                          [WargaController::class, 'semua'])->name('warga.semua');
    Route::get('manajemenWarga/warga/create',        [WargaController::class, 'createWarga']) ->name('warga.warga.create');
    Route::post('manajemenWarga/warga',              [WargaController::class, 'storeWarga'])  ->name('warga.warga.store'); 
    Route::get('manajemenWarga/warga/{warga}/edit',  [WargaController::class, 'editWarga'])   ->name('warga.warga.edit');
    Route::put('manajemenWarga/warga/{warga}',       [WargaController::class, 'updateWarga']) ->name('warga.warga.update');
    Route::delete('manajemenWarga/warga/{warga}',    [WargaController::class, 'destroyWarga'])->name('warga.warga.destroy'); 
    Route::get('manajemenWarga/{kartuKeluarga}',          [WargaController::class, 'show'])   ->name('warga.show');
    Route::get('manajemenWarga/{kartuKeluarga}/edit',     [WargaController::class, 'edit'])   ->name('warga.edit');
    Route::put('manajemenWarga/{kartuKeluarga}',          [WargaController::class, 'update']) ->name('warga.update');
    Route::delete('manajemenWarga/{kartuKeluarga}',       [WargaController::class, 'destroy'])->name('warga.destroy');

    // Anggota Keluarga
    Route::get('manajemenWarga/{kartuKeluarga}/anggota/create', [WargaController::class, 'createAnggota'])->name('warga.anggota.create');
    Route::post('manajemenWarga/{kartuKeluarga}/anggota',       [WargaController::class, 'storeAnggota']) ->name('warga.anggota.store');
    Route::get('anggota/{anggota}/edit',  [WargaController::class, 'editAnggota'])  ->name('warga.anggota.edit');
    Route::put('anggota/{anggota}',       [WargaController::class, 'updateAnggota'])->name('warga.anggota.update');
    Route::delete('anggota/{anggota}',    [WargaController::class, 'destroyAnggota'])->name('warga.anggota.destroy');

        // Keluhan
    Route::get('keluhan',              [KeluhanController::class, 'index']) ->name('keluhan.index');
    Route::get('keluhan/{keluhan}',    [KeluhanController::class, 'show'])  ->name('keluhan.show');
    Route::put('keluhan/{keluhan}',    [KeluhanController::class, 'update'])->name('keluhan.update');
    Route::post('keluhan/{keluhan}/pesan', [KeluhanController::class, 'kirimPesan'])->name('keluhan.pesan');
    
});

// Route Warga
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'wargaIndex'])->name('dashboard');
    Route::get('/data-saya', [WargaController::class, 'dataSaya'])->name('data-saya');
    Route::get('keluhan',              [App\Http\Controllers\Warga\KeluhanController::class, 'index']) ->name('keluhan.index');
    Route::get('keluhan/create',       [App\Http\Controllers\Warga\KeluhanController::class, 'create'])->name('keluhan.create');
    Route::post('keluhan',             [App\Http\Controllers\Warga\KeluhanController::class, 'store']) ->name('keluhan.store');
    Route::get('keluhan/{keluhan}',    [App\Http\Controllers\Warga\KeluhanController::class, 'show'])  ->name('keluhan.show');
    Route::post('keluhan/{keluhan}/pesan', [App\Http\Controllers\Warga\KeluhanController::class, 'kirimPesan'])->name('keluhan.pesan');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile',          [ProfileControlller::class, 'show'])->name('profile');
    Route::get('/profile/edit',     [ProfileControlller::class, 'edit'])->name('profile.edit');
 
    Route::patch('/profile/foto',     [ProfileControlller::class, 'updateFoto'])->name('profile.update.foto');
    Route::delete('/profile/foto',    [ProfileControlller::class, 'hapusFoto'])->name('profile.hapus.foto');
    Route::patch('/profile/akun',     [ProfileControlller::class, 'updateAkun'])->name('profile.update.akun');
    Route::patch('/profile/password', [ProfileControlller::class, 'updatePassword'])->name('profile.update.password');
    Route::patch('/profile/warga',    [ProfileControlller::class, 'updateWarga'])->name('profile.update.warga');
});

