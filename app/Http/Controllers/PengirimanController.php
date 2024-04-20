<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\DataEkspedisi;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PengirimanController extends Controller
{
    public function request_pengiriman()
    {
        $title = 'request pengiriman';
        $data = DataEkspedisi::where('created_by', Auth::user()->id)->latest()->get();

        return view('back.pages.pengiriman.request-pengiriman.request-pengiriman', compact('title', 'data'));
    }

    public function tambah_request_pengiriman($id = null)
    {
        $title = 'request pengiriman';
        $data = DataEkspedisi::find($id);
        $province = Provinces::get();

        return view('back.pages.pengiriman.request-pengiriman.tambah-request-pengiriman', compact('title', 'data', "id", "province"));
    }

    public function simpan_request_pengiriman(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = DataEkspedisi::find($request->id);

            $validation = Validator::make($request->all(), [
                "file_surat" => "required|mimes:pdf"
            ]);

            if ($validation->fails()) {
                throw new \Exception("Data upload harus pdf");
            }

            $destinationPath = 'images';
            $file = Uuid::uuid4()->getHex().$request->file_surat->getClientOriginalName();
            $request->file_surat->move(public_path($destinationPath), $file);

            $cekBiaya = Biaya::where('district_id', $request->district_id)->first();

            if (empty($data)) {
                $data = DataEkspedisi::create([
                    "district_id" => $request->district_id,
                    "nama_penerima" => $request->nama_penerima,
                    "alamat_asal" => $request->alamat_asal,
                    "alamat_penerima" => $request->alamat_penerima,
                    "nama_barang" => $request->nama_barang,
                    "jumlah_barang" => $request->jumlah_barang,
                    "volume" => $request->volume,
                    "note" => $request->note,
                    "biaya" => $cekBiaya->biaya,
                    "file_surat_pengiriman" => $file,
                    "created_by" => Auth::user()->id
                ]);

                if (!$data->save()) {
                    throw new \Exception("Terjadi kesalahan saat menyimpan, silahkan coba lagi");
                }
            } else {
                $data->district_id = $request->district_id;
                $data->nama_penerima = $request->nama_penerima;
                $data->alamat_asal = $request->alamat_asal;
                $data->alamat_penerima = $request->alamat_penerima;
                $data->nama_barang = $request->nama_barang;
                $data->volume = $request->volume;
                $data->note = $request->note;
                $data->biaya = $cekBiaya->biaya;
                $data->file_surat_pengiriman = $file;

                if (!$data->update()) {
                    throw new \Exception("Terjadi kesalahan saat menyimpan, silahkan coba lagi");
                }
            }

            DB::commit();

            return redirect()->route('request-pengiriman')->with('success', 'Berhasil melakukan request pengiriman');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
