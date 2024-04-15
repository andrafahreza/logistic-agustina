<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PenggunaController::class, 'index'])->name('beranda');
Route::get('/tentang', [PenggunaController::class, 'tentang'])->name('tentang-kami');
Route::get('/layanan', [PenggunaController::class, 'layanan'])->name('layanan');
Route::get('/ceh-harga', [PenggunaController::class, 'cekHarga'])->name('cek-harga');
Route::get('/syarat', [PenggunaController::class, 'syarat'])->name('syarat');
Route::get('/kontak', [PenggunaController::class, 'kontak'])->name('kontak-kami');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth'])->name('authenticate');

Route::middleware('auth')->group(function() {
    Route::get("home", [HomeController::class, 'index'])->name('home');
    Route::get("logout", [AuthController::class, 'logout'])->name('logout');
});
