<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function verifikasi()
    {
        $title = "verifikasi";
        $level = Level::where('nama_level', 'pelanggan')->first();
        if (empty($level)) {
            abort(404);
        }

        $data = User::where('status', 'non_active')
        ->where('level_id', $level->id)
        ->latest()
        ->get();

        return view('back.pages.user.verifikasi', compact('title', 'data'));
    }

    public function verifikasi_pelanggan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);
            if (empty($data)) {
                throw new \Exception("Pelanggan tidak ditemukan");
            }

            $data->status = "active";

            if (!$data->update()) {
                throw new \Exception("Gagal memverifikasi pelanggan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with('success', "Berhasil memverifikasi pelanggan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function users()
    {
        $title = "users";
        $level = Level::where('nama_level', 'pelanggan')->first();
        if (empty($level)) {
            abort(404);
        }

        $data = User::whereNot("id", Auth::user()->id)
        ->where('level_id', $level->id)
        ->latest()
        ->get();

        return view('back.pages.user.pelanggan', compact(['title', 'data']));
    }

    public function nonactive_user(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "non_active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal menonaktifkan users");
            }

            DB::commit();

            return redirect()->route('users')->with('success', "Berhasil menonaktifkan users");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function active_user(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal mengaktifkan user");
            }

            DB::commit();

            return redirect()->route('users')->with('success', "Berhasil mengaktifkan user");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Admin
    public function admin()
    {
        $title = "admin";
        $level = Level::where('nama_level', 'admin')->first();
        if (empty($level)) {
            abort(404);
        }

        $data = User::whereNot("id", Auth::user()->id)
        ->where('level_id', $level->id)
        ->latest()
        ->get();

        return view('back.pages.user.admin', compact(['title', 'data']));
    }

    public function data_admin($id)
    {
        $data = User::find($id);

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Error: $message"
            ]);
        }
    }

    public function simpan_admin(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = User::find($id);

            if (empty($data)) {
                $level = Level::where('nama_level', 'admin')->first();
                if (empty($level)) {
                    throw new \Exception("Level admin belum ditambahkan");
                }

                $data = User::create([
                    "level_id" => $level->id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "nama" => $request->nama,
                    "jenis_kelamin" => $request->jenis_kelamin,
                    "alamat" => $request->alamat,
                    "email" => $request->email,
                    "no_telepon" => $request->no_telepon,
                    "status" => "active"
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data2");
                }

            } else {
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->email = $request->email;
                $data->no_telepon = $request->no_telepon;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('admin')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function nonactive_admin(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "non_active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal menonaktifkan admin");
            }

            DB::commit();

            return redirect()->route('admin')->with('success', "Berhasil menonaktifkan admin");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function active_admin(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal mengaktifkan admin");
            }

            DB::commit();

            return redirect()->route('admin')->with('success', "Berhasil mengaktifkan admin");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus_admin(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus admin");
            }


            DB::commit();

            return redirect()->route('admin')->with('success', "Berhasil menghapus admin");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // OPERATOR
    public function operator()
    {
        $title = "operator";
        $level = Level::where('nama_level', 'operator')->first();
        if (empty($level)) {
            abort(404);
        }

        $data = User::whereNot("id", Auth::user()->id)
        ->where('level_id', $level->id)
        ->latest()
        ->get();

        return view('back.pages.user.operator', compact(['title', 'data']));
    }

    public function data_operator($id)
    {
        $data = User::find($id);

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Error: $message"
            ]);
        }
    }

    public function simpan_operator(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = User::find($id);

            if (empty($data)) {
                $level = Level::where('nama_level', 'operator')->first();
                if (empty($level)) {
                    throw new \Exception("Level operator belum ditambahkan");
                }

                $data = User::create([
                    "level_id" => $level->id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "nama" => $request->nama,
                    "jenis_kelamin" => $request->jenis_kelamin,
                    "alamat" => $request->alamat,
                    "email" => $request->email,
                    "no_telepon" => $request->no_telepon,
                    "status" => "active"
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data2");
                }

            } else {
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->email = $request->email;
                $data->no_telepon = $request->no_telepon;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('operator')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function nonactive_operator(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "non_active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal menonaktifkan operator");
            }

            DB::commit();

            return redirect()->route('operator')->with('success', "Berhasil menonaktifkan operator");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function active_operator(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal mengaktifkan operator");
            }

            DB::commit();

            return redirect()->route('operator')->with('success', "Berhasil mengaktifkan operator");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus_operator(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus operator");
            }


            DB::commit();

            return redirect()->route('operator')->with('success', "Berhasil menghapus operator");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Keuangan
    public function keuangan()
    {
        $title = "keuangan";
        $level = Level::where('nama_level', 'keuangan')->first();
        if (empty($level)) {
            abort(404);
        }

        $data = User::whereNot("id", Auth::user()->id)
        ->where('level_id', $level->id)
        ->latest()
        ->get();

        return view('back.pages.user.keuangan', compact(['title', 'data']));
    }

    public function data_keuangan($id)
    {
        $data = User::find($id);

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Error: $message"
            ]);
        }
    }

    public function simpan_keuangan(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = User::find($id);

            if (empty($data)) {
                $level = Level::where('nama_level', 'keuangan')->first();
                if (empty($level)) {
                    throw new \Exception("Level keuangan belum ditambahkan");
                }

                $data = User::create([
                    "level_id" => $level->id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "nama" => $request->nama,
                    "jenis_kelamin" => $request->jenis_kelamin,
                    "alamat" => $request->alamat,
                    "email" => $request->email,
                    "no_telepon" => $request->no_telepon,
                    "status" => "active"
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data2");
                }

            } else {
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->email = $request->email;
                $data->no_telepon = $request->no_telepon;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('keuangan')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function nonactive_keuangan(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "non_active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal menonaktifkan keuangan");
            }

            DB::commit();

            return redirect()->route('keuangan')->with('success', "Berhasil menonaktifkan keuangan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function active_keuangan(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengguna = User::find($request->id);
            $pengguna->status = "active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal mengaktifkan keuangan");
            }

            DB::commit();

            return redirect()->route('keuangan')->with('success', "Berhasil mengaktifkan keuangan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus_keuangan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus keuangan");
            }


            DB::commit();

            return redirect()->route('keuangan')->with('success', "Berhasil menghapus keuangan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Kepala perusahaan
    public function kepala()
    {
        $title = "kepala perusahaan";
        $level = Level::where('nama_level', 'kepala_perusahaan')->first();
        if (empty($level)) {
            abort(404);
        }

        $data = User::whereNot("id", Auth::user()->id)
        ->where('level_id', $level->id)
        ->latest()
        ->get();

        return view('back.pages.user.kepala', compact(['title', 'data']));
    }

    public function data_kepala($id)
    {
        $data = User::find($id);

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Error: $message"
            ]);
        }
    }

    public function simpan_kepala(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = User::find($id);

            if (empty($data)) {
                $level = Level::where('nama_level', 'kepala_perusahaan')->first();
                if (empty($level)) {
                    throw new \Exception("Level kepala perusahaan belum ditambahkan");
                }

                $data = User::create([
                    "level_id" => $level->id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "nama" => $request->nama,
                    "jenis_kelamin" => $request->jenis_kelamin,
                    "alamat" => $request->alamat,
                    "email" => $request->email,
                    "no_telepon" => $request->no_telepon,
                    "status" => "active"
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data");
                }

            } else {
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->email = $request->email;
                $data->no_telepon = $request->no_telepon;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('kepala')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus_kepala(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }


            DB::commit();

            return redirect()->route('kepala')->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
