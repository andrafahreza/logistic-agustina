<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $title = "beranda";
        return view('front.home', compact('title'));
    }

    public function tentang()
    {
        $title = "tentang kami";
        return view('front.tentang-kami', compact('title'));
    }

    public function layanan()
    {
        $title = "layanan";
        return view('front.layanan', compact('title'));
    }

    public function cekHarga()
    {
        $title = "cek harga";
        return view('front.harga', compact('title'));
    }

    public function syarat()
    {
        $title = "syarat";
        return view('front.syarat', compact('title'));
    }

    public function kontak()
    {
        $title = "kontak";
        return view('front.kontak', compact('title'));
    }
}
