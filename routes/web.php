<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PenggunaController::class, 'index'])->name('beranda');
Route::get('/tentang', [PenggunaController::class, 'tentang'])->name('tentang-kami');
Route::get('/layanan', [PenggunaController::class, 'layanan'])->name('layanan');
Route::get('/ceh-harga', [PenggunaController::class, 'cekHarga'])->name('cek-harga');
Route::get('/syarat', [PenggunaController::class, 'syarat'])->name('syarat');
Route::get('/kontak', [PenggunaController::class, 'kontak'])->name('kontak-kami');

Route::get('/kecamatan/{id?}', [WilayahController::class, 'kecamatan'])->name('get-kecamatan');
Route::get('/kelurahan/{id?}', [WilayahController::class, 'kelurahan'])->name('get-kelurahan');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth'])->name('authenticate');

Route::middleware('auth')->group(function() {
    Route::get("home", [HomeController::class, 'index'])->name('home');
    Route::get("logout", [AuthController::class, 'logout'])->name('logout');

    Route::prefix("master-data")->group(function() {
        Route::prefix("supir")->group(function() {
            Route::get("/", [SupirController::class, 'index'])->name('supir');
            Route::get("simpan/{id?}", [SupirController::class, 'data'])->name('data-supir');
            Route::post("simpan/{id?}", [SupirController::class, 'simpan'])->name('simpan-supir');
            Route::post("hapus", [SupirController::class, 'hapus'])->name('hapus-supir');
        });

        Route::prefix("biaya")->group(function() {
            Route::get("/", [BiayaController::class, 'index'])->name('biaya');
            Route::get("simpan/{id?}", [BiayaController::class, 'data'])->name('data-biaya');
            Route::post("simpan/{id?}", [BiayaController::class, 'simpan'])->name('simpan-biaya');
            Route::post("hapus", [BiayaController::class, 'hapus'])->name('hapus-biaya');
        });

        Route::prefix("vendor")->group(function() {
            Route::get("/", [VendorController::class, 'index'])->name('vendor');
            Route::get("simpan/{id?}", [VendorController::class, 'data'])->name('data-vendor');
            Route::post("simpan/{id?}", [VendorController::class, 'simpan'])->name('simpan-vendor');
            Route::post("nonactive", [VendorController::class, 'nonactive'])->name('nonactive-vendor');
            Route::post("active", [VendorController::class, 'active'])->name('active-vendor');
            Route::post("hapus", [VendorController::class, 'hapus'])->name('hapus-vendor');
        });
    });

});
