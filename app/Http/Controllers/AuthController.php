<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('back.login');
    }

    public function auth(Request $request)
    {
        try {
            $credentials = $request->validate([
                "username" => 'required',
                "password" => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                if (Auth::user()->status == "non_active") {
                    throw new \Exception("Status akun anda non aktif, silahkan hubungi administrator");
                }

                $request->session()->regenerate();
                return redirect()->intended("home");
            }

            throw new \Exception("Username atau password salah");

        } catch (\Throwable $th) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['message' => $th->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
