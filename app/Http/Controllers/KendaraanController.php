<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    public function cek_kendaraan($id = null)
    {
        $data = Kendaraan::where('vendor_id', $id)->get();

        if (empty($data)) {
            $data = [
                "alert" => 0,
                "data" => null
            ];
        } else {
            $data = [
                "alert" => 1,
                "data" => $data
            ];
        }


        return response()->json($data);
    }

    public function index($id = null)
    {
        $title = "vendor";

        $cek = Vendor::find($id);
        if (empty($cek)) {
            abort(404);
        }

        $data = Kendaraan::where('vendor_id', $id)->latest()->get();

        return view('back.pages.vendor.list-kendaraan', compact("title", "data", "id"));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Kendaraan::create([
                "vendor_id" => $request->vendor_id,
                "no_kendaraan" => $request->no_kendaraan,
                "jenis_kendaraan" => $request->jenis_kendaraan,
                "merk" => $request->merk,
            ]);

            if (!$data->save()) {
                throw new \Exception("Gagal menambah data");
            }

            DB::commit();

            return redirect()->back()->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Kendaraan::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }

            DB::commit();

            return redirect()->back()->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function list_all()
    {
        $title = "kendaraan";
        $data = Kendaraan::latest()->get();
        $vendor = Vendor::get();

        return view('back.pages.kendaraan.index', compact("title", "data", "vendor"));
    }
}
