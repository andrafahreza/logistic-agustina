<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\UserController;
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

Route::get('/pendaftaran', [AuthController::class, 'daftar'])->name('daftar')->middleware('guest');
Route::post('/pendaftaran', [AuthController::class, 'daftarkan'])->name('daftarkan')->middleware('guest');
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth'])->name('authenticate');

Route::middleware('auth')->group(function() {
    Route::get("home", [HomeController::class, 'index'])->name('home');
    Route::get("logout", [AuthController::class, 'logout'])->name('logout');

    Route::get("verifikasi", [UserController::class, 'verifikasi'])->name('verifikasi');
    Route::post("verifikasi", [UserController::class, 'verifikasi_pelanggan'])->name('verifikasi-pelanggan');

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

        Route::prefix("admin")->group(function() {
            Route::get("/", [UserController::class, 'admin'])->name('admin');
            Route::get("simpan/{id?}", [UserController::class, 'data_admin'])->name('data-admin');
            Route::post("simpan/{id?}", [UserController::class, 'simpan_admin'])->name('simpan-admin');
            Route::post("nonactive", [UserController::class, 'nonactive_admin'])->name('nonactive-admin');
            Route::post("active", [UserController::class, 'active_admin'])->name('active-admin');
            Route::post("hapus", [UserController::class, 'hapus_admin'])->name('hapus-admin');
        });

        Route::prefix("operator")->group(function() {
            Route::get("/", [UserController::class, 'operator'])->name('operator');
            Route::get("simpan/{id?}", [UserController::class, 'data_operator'])->name('data-operator');
            Route::post("simpan/{id?}", [UserController::class, 'simpan_operator'])->name('simpan-operator');
            Route::post("nonactive", [UserController::class, 'nonactive_operator'])->name('nonactive-operator');
            Route::post("active", [UserController::class, 'active_operator'])->name('active-operator');
            Route::post("hapus", [UserController::class, 'hapus_operator'])->name('hapus-operator');
        });

        Route::prefix("kepala")->group(function() {
            Route::get("/", [UserController::class, 'kepala'])->name('kepala');
            Route::get("simpan/{id?}", [UserController::class, 'data_kepala'])->name('data-kepala');
            Route::post("simpan/{id?}", [UserController::class, 'simpan_kepala'])->name('simpan-kepala');
            Route::post("hapus", [UserController::class, 'hapus_kepala'])->name('hapus-kepala');
        });

        Route::prefix("vendor")->group(function() {
            Route::get("/", [VendorController::class, 'index'])->name('vendor');
            Route::get("simpan/{id?}", [VendorController::class, 'data'])->name('data-vendor');
            Route::post("simpan/{id?}", [VendorController::class, 'simpan'])->name('simpan-vendor');
            Route::post("nonactive", [VendorController::class, 'nonactive'])->name('nonactive-vendor');
            Route::post("active", [VendorController::class, 'active'])->name('active-vendor');
            Route::post("hapus", [VendorController::class, 'hapus'])->name('hapus-vendor');

            Route::prefix("kendaraan")->group(function() {
                Route::get("list/{id?}", [KendaraanController::class, 'index'])->name('list-kendaraan');
                Route::post("simpan", [KendaraanController::class, 'simpan'])->name('simpan-kendaraan');
                Route::post("hapus", [KendaraanController::class, 'hapus'])->name('hapus-kendaraan');
            });
        });
    });

});
