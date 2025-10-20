<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KategoriBarangController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\LoginController;

// =====================
// Redirect root -> login
// =====================
Route::get('/', function () {
    return redirect()->route('login');
});

// =====================
// LOGIN & LOGOUT
// =====================
Route::controller(LoginController::class)->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// =====================
// Semua route butuh login
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // CRUD kategori
    Route::resource('kategori-barang', KategoriBarangController::class);

    // CRUD barang
    Route::resource('barang', BarangController::class);
    Route::post('/barang/{id}/pakai', [BarangController::class, 'pakai'])->name('barang.pakai');
    Route::post('/barang/{id}/batalkan', [BarangController::class, 'batalkanPakai'])->name('barang.batalkan');

    // CRUD barang masuk
    Route::resource('barang-masuk', BarangMasukController::class);

    // Barang keluar (butuh hapus, jadi tambahkan destroy)
    Route::resource('barang-keluar', BarangKeluarController::class);

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export-excel', [LaporanController::class, 'export'])->name('exportExcel');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('exportPdf');
        Route::get('/preview-excel', [LaporanController::class, 'previewExcel'])->name('previewExcel');
        Route::get('/preview-pdf', [LaporanController::class, 'previewPdf'])->name('previewPdf');
    });
});

// =====================
// Route untuk role user
// =====================
Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
});
