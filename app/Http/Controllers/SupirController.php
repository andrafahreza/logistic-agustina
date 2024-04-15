<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupirController extends Controller
{
    public function index()
    {
        $title = 'supir';
        $data = Supir::latest()->get();

        return view('back.pages.supir.index', compact(['title', 'data']));
    }

    public function data($id)
    {
        $data = Supir::find($id);

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
            $data = Supir::find($id);

            if (empty($data)) {
                $data = Supir::create([
                    "nama" => $request->nama,
                    "sim" => $request->sim,
                    "alamat" => $request->alamat,
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah supir");
                }
            } else {
                $data->nama = $request->nama;
                $data->sim = $request->sim;
                $data->alamat = $request->alamat;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah supir");
                }
            }

            DB::commit();

            return redirect()->route('supir')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Supir::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }

            DB::commit();

            return redirect()->route('supir')->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
