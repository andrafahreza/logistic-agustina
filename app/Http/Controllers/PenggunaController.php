<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\DataEkspedisi;
use App\Models\StatusPesanan;
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
        $data = Biaya::get();

        return view('front.harga', compact('title', 'data'));
    }

    public function track(Request $request)
    {
        $title = "track";
        $data = array();
        $search = false;

        if ($request->isMethod('post')) {
            $ekspedisi = DataEkspedisi::where('no_resi', $request->no_resi)->first();
            if (!empty($ekspedisi)) {
                $data = StatusPesanan::where('data_ekspedisi_id', $ekspedisi->id)->latest()->get();
            }

            $search = true;
        }

        return view('front.track', compact('title', 'data', 'search'));
    }

    public function kontak()
    {
        $title = "kontak";
        return view('front.kontak', compact('title'));
    }
}
