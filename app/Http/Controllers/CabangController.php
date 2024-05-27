<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $title = "cabang";
        $data = Cabang::latest()->get();

        return view('back.pages.cabang.index', compact(['title', 'data']));
    }

    public function data($id)
    {
        $data = Cabang::find($id);

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
            $data = Cabang::find($id);

            if (empty($data)) {
                $data = Cabang::create([
                    "nama_cabang" => $request->nama_cabang,
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data");
                }
            } else {
                $data->nama_cabang = $request->nama_cabang;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('cabang')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Cabang::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }

            DB::commit();

            return redirect()->route('cabang')->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
