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
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\PasswordController as UserPasswordController;

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
// Registration + Password Reset
// =====================
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

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

// Profile routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // update password from profile
    Route::put('/user/password', [UserPasswordController::class, 'update'])->name('password.update');
});

// Admin user management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class);
});

// Local-only test email routes (do not expose in production). Require auth so only logged-in devs can use it.
// limit to admin users only to avoid accidental exposure
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/test-email', [\App\Http\Controllers\MailTestController::class, 'showForm'])->name('test.email.form');
    Route::post('/test-email', [\App\Http\Controllers\MailTestController::class, 'sendTest'])->name('test.email.send');
});
