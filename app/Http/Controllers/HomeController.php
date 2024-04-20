<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $title = "home";
        $pelanggan = Pelanggan::get()->count();
        $nonActive = User::where('status', 'non_active')->get()->count();

        return view('back.pages.home', compact('title', 'pelanggan', 'nonActive', 'user'));
    }
}
