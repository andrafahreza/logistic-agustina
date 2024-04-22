<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\DataEkspedisi;
use App\Models\Districts;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\StatusPesanan;
use App\Models\Supir;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PengirimanController extends Controller
{
    public function request_pengiriman()
    {
        $title = 'request pengiriman';
        $getData = DataEkspedisi::where('created_by', Auth::user()->id)
        ->latest()
        ->get();

        $data = array();
        foreach ($getData as $key => $value) {
            $cekStatus = StatusPesanan::where('data_ekspedisi_id' , $value->id)
            ->whereNot('status', 'denied')
            ->get();

            if ($cekStatus->count() > 0) {
                continue;
            }

            $data[] = $value;
        }

        return view('back.pages.pengiriman.request-pengiriman.request-pengiriman', compact('title', 'data'));
    }

    public function data_request_pengiriman($id = null)
    {
        $data = DataEkspedisi::find($id);

        if (!empty($data)) {
            $status = StatusPesanan::where('data_ekspedisi_id', $id)->latest()->first();
            if (empty($status)) {
                $status = "Menunggu Antrian";
            } else {
                if ($status->status == "process") {
                    $status = "Proses";
                } else if ($status->status == "denied") {
                    $status = "Ditolak";
                } else if ($status->status == "accept") {
                    $status = "Diterima";
                } else {
                    $status = "Selesai";
                }
            }

            $kelurahan = Districts::find($data->district_id);
            $kecamatan = Regencies::find($kelurahan->regency_id);
            $provinsi = Provinces::find($kecamatan->province_id);

            $data = [
                "status" => $status,
                "no_awb" => $data->no_awb != null ? $data->no_awb : "-",
                "biaya" => "Rp. ".number_format($data->biaya),
                "nama_barang" => $data->nama_barang,
                "jumlah_barang" => $data->jumlah_barang,
                "volume" => $data->volume,
                "nama_penerima" => $data->nama_penerima,
                "alamat_asal" => $data->alamat_asal,
                "alamat_penerima" => $data->alamat_penerima,
                "kendaraan" => $data->kendaraan_id != null ? $data->kendaraan->no_kendaraan : "-",
                "supir" => $data->supir_id != null ? $data->supir->nama : "-",
                "note" => $data->note,
                "provinsi" => $provinsi->name,
                "kecamatan" => $kecamatan->name,
                "kelurahan" => $kelurahan->name
            ];

            $data = [
                "alert" => 1,
                "data" => $data
            ];
        } else {
            $data = [
                "alert" => 0,
                "data" => null
            ];
        }

        return response()->json($data);
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

    public function hapus_request_pengiriman(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = DataEkspedisi::find($request->id);
            $file = $data->file_surat_pengiriman;

            if (!$data->delete()) {
                throw new \Exception("Terjadi kesalahan penghapusan data");
            }

            if (File::exists(public_path('images')."/".$file)) {
                File::delete(public_path('images')."/".$file);
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function tolak_request_pengiriman(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = DataEkspedisi::find($request->id);
            $status = StatusPesanan::create([
                "data_ekspedisi_id" => $data->id,
                "waktu" => date('Y-m-d H:i:s'),
                "note" => $request->note,
                "status" => "denied"
            ]);

            if (!$status->save()) {
                throw new \Exception("Terjadi kesalahan penolakan data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Daftar Pemesanan
    public function daftar_pesanan()
    {
        $title = "daftar pesanan";
        $getData = DataEkspedisi::where('created_by', Auth::user()->id)->latest()->get();

        $data = array();
        foreach ($getData as $key => $value) {
            if ($value->status->count() < 0) {
                continue;
            }

            $statusDenied = false;
            foreach ($value->status as $kunci => $isi) {
                if ($isi->status == "denied") {
                    $statusDenied = true;
                }
            }

            if ($statusDenied) {
                continue;
            }

            $data[] = $value;
        }

        return view('back.pages.pengiriman.daftar-pesanan.index', compact('title', 'data'));
    }

    // Pengelola
    public function pengelola_pengiriman()
    {
        $title = "pengelola pengiriman";
        $getData = DataEkspedisi::latest()->get();

        $data = array();
        foreach ($getData as $key => $value) {
            if ($value->status->count() < 0) {
                continue;
            }

            $statusDenied = false;
            foreach ($value->status as $kunci => $isi) {
                if ($isi->status == "denied") {
                    $statusDenied = true;
                }
            }

            if ($statusDenied) {
                continue;
            }

            $data[] = $value;
        }

        $vendor = Vendor::get();
        $supir = Supir::get();

        return view('back.pages.pengiriman.request-pengiriman.pengelola-pengiriman', compact('title', 'data', 'vendor', 'supir'));
    }

    public function terima_request_pengiriman(Request $request)
    {
        DB::beginTransaction();

        try {
            $validation = Validator::make($request->all(), [
                "file_awb" => "required|mimes:pdf"
            ]);

            if ($validation->fails()) {
                throw new \Exception("Data upload harus pdf");
            }

            $data = DataEkspedisi::find($request->id);
            $status = StatusPesanan::create([
                "data_ekspedisi_id" => $data->id,
                "waktu" => date('Y-m-d H:i:s'),
                "note" => "Pesanan diterima, sedang diproses",
                "status" => "accept"
            ]);

            if (!$status->save()) {
                throw new \Exception("Terjadi kesalahan saat menyimpan status, silahkan coba lagi");
            }

            $data->kendaraan_id = $request->kendaraan_id;
            $data->supir_id = $request->supir_id;
            $data->no_awb = $request->no_awb;

            $destinationPath = 'images-awb';
            $file = Uuid::uuid4()->getHex().$request->file_awb->getClientOriginalName();
            $request->file_awb->move(public_path($destinationPath), $file);

            $data->file_awb = $file;

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan saat memperbarui pesanan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menerima pesanan");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
