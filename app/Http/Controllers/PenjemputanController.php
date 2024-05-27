<?php

namespace App\Http\Controllers;

use App\Models\Penjemputan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PenjemputanController extends Controller
{
    public function index()
    {
        $title = "pengelola penjemputan";
        $data = Penjemputan::latest()->get();

        return view('back.pages.pengiriman.penjemputan.index', compact(['title', 'data']));
    }

    public function data($id)
    {
        $data = Penjemputan::find($id);

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
            $data = Penjemputan::find($id);

            if (empty($data)) {
                $data = Penjemputan::create([
                    "nama_kurir" => $request->nama_kurir,
                    "alamat_penjemputan" => $request->alamat_penjemputan,
                    "status" => "proses",
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data");
                }
            } else {
                $data->nama_kurir = $request->nama_kurir;
                $data->alamat_penjemputan = $request->alamat_penjemputan;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('pengelola-penjemputan')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Penjemputan::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }

            DB::commit();

            return redirect()->route('pengelola-penjemputan')->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function batal(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Penjemputan::find($request->id);
            $data->keterangan = $request->keterangan;
            $data->status = "gagal";

            if (!$data->update()) {
                throw new \Exception("Gagal memproses data");
            }

            DB::commit();

            return redirect()->route('pengelola-penjemputan')->with('success', "Berhasil membatalkan penjemputan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Penjemputan::find($request->id);
            if (empty($data)) {
                throw new \Exception("Data penjemputan tidak ditemukan");
            }

            $request->validate([
                'bukti_penjemputan' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $imageName = time().'.'.$request->bukti_penjemputan->extension();
            $request->bukti_penjemputan->move(public_path('images'), $imageName);

            if (File::exists(public_path($data->bukti_penjemputan))) {
                File::delete(public_path($data->bukti_penjemputan));
            }

            $data->bukti_penjemputan = "images/$imageName";

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan saat mengupload foto");
            }

            DB::commit();

            return redirect()->route('pengelola-penjemputan')->with('success', "Berhasil upload bukti");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
