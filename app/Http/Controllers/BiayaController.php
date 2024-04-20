<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Districts;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BiayaController extends Controller
{
    public function cek_biaya($id = null)
    {
        $data = Biaya::where('district_id', $id)->first();

        if (empty($data)) {
            $data = [
                "alert" => 0,
                "data" => null
            ];
        } else {
            $data = [
                "alert" => 1,
                "data" => "Rp. ".number_format($data->biaya)
            ];
        }

        return response()->json($data);
    }

    public function index()
    {
        $title = "biaya";
        $data = Biaya::latest()->get();
        $province = Provinces::get();

        return view('back.pages.biaya.index', compact(['title', 'data', 'province']));
    }

    public function data($id)
    {
        $data = Biaya::find($id);

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
            $data = Biaya::find($id);

            $cekDistrict = Districts::find($request->district_id);
            if (empty($cekDistrict)) {
                throw new \Exception("Kelurahan tidak ditemukan");
            }

            if (empty($data)) {
                $data = Biaya::create([
                    "district_id" => $request->district_id,
                    "biaya" => $request->biaya,
                    "service" => $request->service,
                    "minimal_berat" => $request->minimal_berat,
                    "pengiriman" => $request->pengiriman,
                    "jangka_waktu" => $request->jangka_waktu,
                ]);

                if (!$data->save()) {
                    throw new \Exception("Gagal menambah data");
                }
            } else {
                $data->district_id = $request->district_id;
                $data->biaya = $request->biaya;
                $data->service = $request->service;
                $data->minimal_berat = $request->minimal_berat;
                $data->pengiriman = $request->pengiriman;
                $data->jangka_waktu = $request->jangka_waktu;

                if (!$data->update()) {
                    throw new \Exception("Gagal mengubah data");
                }
            }

            DB::commit();

            return redirect()->route('biaya')->with('success', "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Biaya::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }

            DB::commit();

            return redirect()->route('biaya')->with('success', "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
