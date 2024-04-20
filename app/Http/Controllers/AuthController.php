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
    public function daftar()
    {
        return view('back.daftar');
    }

    public function daftarkan(Request $request)
    {
        DB::beginTransaction();

        try {
            $cek = User::where('username', $request->username)->first();
            if (!empty($cek)) {
                throw new \Exception("Username tersebut sudah terdaftar");
            }

            $pelanggan = Pelanggan::create([
                'nomor_bisnis' => $request->nomor_bisnis,
                'npwp' => $request->npwp,
                'jenis_usaha' => $request->jenis_usaha,
                'alamat' => $request->alamat,
                'no_fax' => $request->no_fax,
            ]);

            if (!$pelanggan->save()) {
                throw new \Exception("Gagal mendaftarkan, silahkan coba lagi");
            }

            $level = Level::where('nama_level', 'pelanggan')->first();
            $user = User::create([
                "level_id" => $level->id,
                "pelanggan_id" => $pelanggan->id,
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "nama" => $request->nama,
                "jenis_kelamin" => $request->jenis_kelamin,
                "alamat" => $request->alamat,
                "email" => $request->email,
                "no_telepon" => $request->no_telepon,
                "status" => "non_active",
            ]);

            if (!$user->save()) {
                throw new \Exception("Gagal mendaftarkan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->route('login')->with('success', "Berhasil mendaftarkan akun, silahkan tunggu administrator untuk memverifikasi data anda");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }

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
