<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $title = "vendor";
        $data = Vendor::latest()->get();

        return view('back.pages.vendor.index', compact(['title', 'data']));
    }

    public function data($id)
    {
        $data = Vendor::find($id);

        $data = [
            "id" => $id,
            "kode" => $data->kode,
            "no_ktp" => $data->no_ktp,
            "username" => $data->user->username,
            "alamat" => $data->user->alamat,
            "email" => $data->user->email,
            "no_telepon" => $data->user->no_telepon
        ];

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

    public function simpan(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = Vendor::find($id);

            if (empty($data)) {
                $data = Vendor::create([
                    "kode" => $request->kode,
                    "no_ktp" => $request->no_ktp,
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data");
                }

                // Add Akun
                $level = Level::where('nama_level', 'vendor')->first();
                if (empty($level)) {
                    throw new \Exception("Level vendor belum ditambahkan");
                }

                $data2 = User::create([
                    "level_id" => $level->id,
                    "vendor_id" => $data->id,
                    "username" => $request->username,
                    "password" => Hash::make('vendor123'),
                    "nama" => $request->kode,
                    "jenis_kelamin" => 'l',
                    "alamat" => $request->alamat,
                    "email" => $request->email,
                    "no_telepon" => $request->no_telepon,
                    "status" => "active"
                ]);

                if (!$data2->save()) {
                    throw new \Exception("Gagal menambah data2");
                }

            } else {
                $data->kode = $request->kode;
                $data->no_ktp = $request->no_ktp;

                $data2 = User::where('vendor_id', $data->id)->first();
                $data2->username = $request->username;
                $data2->nama = $request->kode;
                $data2->alamat = $request->alamat;
                $data2->email = $request->email;
                $data2->no_telepon = $request->no_telepon;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('vendor')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function nonactive(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Vendor::find($request->id);
            $pengguna = User::where('vendor_id', $data->id)->first();
            $pengguna->status = "non_active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal menonaktifkan vendor");
            }

            DB::commit();

            return redirect()->route('vendor')->with('success', "Berhasil menonaktifkan vendor");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function active(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Vendor::find($request->id);
            $pengguna = User::where('vendor_id', $data->id)->first();
            $pengguna->status = "active";

            if (!$pengguna->update()) {
                throw new \Exception("Gagal mengaktifkan vendor");
            }

            DB::commit();

            return redirect()->route('vendor')->with('success', "Berhasil mengaktifkan vendor");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Vendor::find($request->id);
            $data2 = User::where('vendor_id', $data->id)->first();

            if (!$data2->delete()) {
                throw new \Exception("Gagal menghapus pengguna");
            }
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }


            DB::commit();

            return redirect()->route('vendor')->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
