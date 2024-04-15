<?php

use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PenggunaController::class, 'index'])->name('beranda');
Route::get('/tentang', [PenggunaController::class, 'tentang'])->name('tentang-kami');
Route::get('/layanan', [PenggunaController::class, 'layanan'])->name('layanan');
Route::get('/ceh-harga', [PenggunaController::class, 'cekHarga'])->name('cek-harga');
Route::get('/syarat', [PenggunaController::class, 'syarat'])->name('syarat');
Route::get('/kontak', [PenggunaController::class, 'kontak'])->name('kontak-kami');
