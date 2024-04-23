<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PengirimanController;
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
Route::get('/cek-biaya/{id?}', [BiayaController::class, 'cek_biaya'])->name('cek-biaya');
Route::get('/cek-kendaraan/{id?}', [KendaraanController::class, 'cek_kendaraan'])->name('cek-kendaraan');

Route::get('/pendaftaran', [AuthController::class, 'daftar'])->name('daftar')->middleware('guest');
Route::post('/pendaftaran', [AuthController::class, 'daftarkan'])->name('daftarkan')->middleware('guest');
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth'])->name('authenticate');

Route::middleware('auth')->group(function() {
    Route::get("home", [HomeController::class, 'index'])->name('home');
    Route::get("logout", [AuthController::class, 'logout'])->name('logout');
    Route::get("verifikasi", [UserController::class, 'verifikasi'])->name('verifikasi');
    Route::post("verifikasi", [UserController::class, 'verifikasi_pelanggan'])->name('verifikasi-pelanggan');

    Route::prefix("pengiriman")->group(function() {
        Route::get("request-pengiriman", [PengirimanController::class, 'request_pengiriman'])->name('request-pengiriman');
        Route::get("data-request-pengiriman/{id?}", [PengirimanController::class, 'data_request_pengiriman'])->name('data-request-pengiriman');
        Route::get("tambah-request-pengiriman/{id?}", [PengirimanController::class, 'tambah_request_pengiriman'])->name('tambah-request-pengiriman');
        Route::post("simpan-request-pengiriman", [PengirimanController::class, 'simpan_request_pengiriman'])->name('simpan-request-pengiriman');
        Route::post("hapus-request-pengiriman", [PengirimanController::class, 'hapus_request_pengiriman'])->name('hapus-request-pengiriman');
        Route::post("tolak-request-pengiriman", [PengirimanController::class, 'tolak_request_pengiriman'])->name('tolak-request-pengiriman');
        Route::post("terima-request-pengiriman", [PengirimanController::class, 'terima_request_pengiriman'])->name('terima-request-pengiriman');

        Route::get("daftar-pesanan", [PengirimanController::class, 'daftar_pesanan'])->name('daftar-pesanan');

        Route::get("pengelola-pengiriman", [PengirimanController::class, 'pengelola_pengiriman'])->name('pengelola-pengiriman');
    });

    Route::prefix("master-data")->group(function() {
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

        Route::prefix("keuangan")->group(function() {
            Route::get("/", [UserController::class, 'keuangan'])->name('keuangan');
            Route::get("simpan/{id?}", [UserController::class, 'data_keuangan'])->name('data-keuangan');
            Route::post("simpan/{id?}", [UserController::class, 'simpan_keuangan'])->name('simpan-keuangan');
            Route::post("nonactive", [UserController::class, 'nonactive_keuangan'])->name('nonactive-keuangan');
            Route::post("active", [UserController::class, 'active_keuangan'])->name('active-keuangan');
            Route::post("hapus", [UserController::class, 'hapus_keuangan'])->name('hapus-keuangan');
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

        Route::prefix("users")->group(function() {
            Route::get("/", [UserController::class, 'users'])->name('users');
            Route::post("nonactive", [UserController::class, 'nonactive_user'])->name('nonactive-user');
            Route::post("active", [UserController::class, 'active_user'])->name('active-user');
        });

        Route::prefix("pesanan")->group(function() {
            Route::prefix("biaya")->group(function() {
                Route::get("/", [BiayaController::class, 'index'])->name('biaya');
                Route::get("simpan/{id?}", [BiayaController::class, 'data'])->name('data-biaya');
                Route::post("simpan/{id?}", [BiayaController::class, 'simpan'])->name('simpan-biaya');
                Route::post("hapus", [BiayaController::class, 'hapus'])->name('hapus-biaya');
            });

            Route::prefix("kendaraan")->group(function() {
                Route::get("/", [KendaraanController::class, 'list_all'])->name('kendaraan');
            });

            Route::prefix("supir")->group(function() {
                Route::get("/", [SupirController::class, 'index'])->name('supir');
                Route::get("simpan/{id?}", [SupirController::class, 'data'])->name('data-supir');
                Route::post("simpan/{id?}", [SupirController::class, 'simpan'])->name('simpan-supir');
                Route::post("hapus", [SupirController::class, 'hapus'])->name('hapus-supir');
            });
        });
    });

    Route::prefix("keuangan")->group(function() {
        Route::prefix("hutang-piutang")->group(function() {
            Route::get("/", [KeuanganController::class, 'hutang_piutang'])->name('hutang-piutang');
            Route::post("simpan-pembayaran-ekspedisi", [KeuanganController::class, 'simpan_pembayaran_ekspedisi'])->name('simpan-pembayaran-ekspedisi');
            Route::post("hapus-pembayaran-ekspedisi", [KeuanganController::class, 'hapus_pembayaran_ekspedisi'])->name('hapus-pembayaran-ekspedisi');
        });
    });

});
