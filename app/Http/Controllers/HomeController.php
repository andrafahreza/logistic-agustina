<?php

namespace App\Http\Controllers;

use App\Models\DataEkspedisi;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = "home";
        $user = Auth::user();
        $pesanan = DataEkspedisi::get();

        return view('back.pages.home', compact('title', 'pesanan', 'user'));
    }
}
