<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Cabang;
use App\Models\DataEkspedisi;
use App\Models\Districts;
use App\Models\Penjemputan;
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
                $status = "Menunggu Pengiriman";
            } else {
                if ($status->status == "process") {
                    $status = "Proses";
                } else if ($status->status == "denied") {
                    $status = "Dibatalkan";
                }  else {
                    $status = "Selesai";
                }
            }

            $cabang = Cabang::find($data->cabang_id);
            $statusPesanan = StatusPesanan::where('data_ekspedisi_id', $id)->latest()->get();
            $htmlStatus = "<tbody>";
            foreach ($statusPesanan as $key => $value) {
                $tgl = date('d-m-Y H:i', strtotime($value->waktu));
                if ($value->status == "process") {
                    $getStatus = "Proses";
                } else if ($value->status == "denied") {
                    $getStatus = "Dibatalkan";
                } else {
                    $getStatus = "Selesai";
                }

                $htmlStatus .= "<tr>
                    <td>$tgl</td>
                    <td>$value->note</td>
                    <td>$getStatus</td>
                </tr>";
            }
            $htmlStatus .= "</tbody>";

            $data = [
                "status" => $status,
                "no_resi" => $data->no_resi,
                "biaya" => "Rp. ".number_format($data->biaya),
                "nama_barang" => $data->nama_barang,
                "jumlah_barang" => $data->jumlah_barang,
                "volume" => $data->volume,
                "nama_penerima" => $data->nama_penerima,
                "alamat_asal" => $data->alamat_asal,
                "alamat_penerima" => $data->alamat_penerima,
                "supir" => $data->supir_id != null ? $data->supir->nama : "-",
                "note" => $data->note,
                "cabang" => $cabang->nama_cabang,
                "htmlStatus" => $htmlStatus
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
        $title = 'pengelola pengiriman';
        $data = DataEkspedisi::find($id);
        $cabang = Cabang::get();
        $penjemputan = Penjemputan::where('status', 'proses')->latest()->get();
        $supir = Supir::get();

        return view('back.pages.pengiriman.request-pengiriman.tambah-request-pengiriman', compact('title', 'data', "id", "cabang", "penjemputan", "supir"));
    }

    public function simpan_request_pengiriman(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = DataEkspedisi::find($request->id);
            $request->biaya = str_replace("Rp. ", "", $request->biaya);
            $request->biaya = str_replace(".", "", $request->biaya);
            $request->biaya = str_replace(",", "", $request->biaya);

            if ($request->penjemputan_id) {
                $penjemputan = Penjemputan::find($request->penjemputan_id);
                $penjemputan->status = "berhasil";

                if (!$penjemputan->update()) {
                    throw new \Exception("Gagal memperbarui penjemputan");
                }
            }

            if (empty($data)) {
                $data = DataEkspedisi::create([
                    "supir_id" => $request->supir_id,
                    "penjemputan_id" => $request->penjemputan_id,
                    "cabang_id" => $request->cabang,
                    "no_resi" => $request->no_resi,
                    "nama_asal" => $request->nama_pengirim,
                    "nama_penerima" => $request->nama_penerima,
                    "alamat_asal" => $request->alamat_asal,
                    "alamat_penerima" => $request->alamat_penerima,
                    "nama_barang" => $request->nama_barang,
                    "jumlah_barang" => $request->jumlah_barang,
                    "volume" => $request->volume,
                    "note" => $request->note,
                    "biaya" => (int)$request->biaya,
                    "created_by" => Auth::user()->id
                ]);

                if (!$data->save()) {
                    throw new \Exception("Terjadi kesalahan saat menyimpan, silahkan coba lagi");
                }
            } else {
                $data->supir_id = $request->supir_id;
                $data->penjemputan_id = $request->penjemputan_id;
                $data->cabang_id = $request->cabang_id;
                $data->no_resi = $request->no_resi;
                $data->nama_asal = $request->nama_pengirim;
                $data->nama_penerima = $request->nama_penerima;
                $data->alamat_asal = $request->alamat_asal;
                $data->alamat_penerima = $request->alamat_penerima;
                $data->nama_barang = $request->nama_barang;
                $data->jumlah_barang = $request->jumlah_barang;
                $data->volume = $request->volume;
                $data->note = $request->note;
                $data->biaya = $request->biaya;

                if (!$data->update()) {
                    throw new \Exception("Terjadi kesalahan saat menyimpan, silahkan coba lagi");
                }
            }

            DB::commit();

            return redirect()->route('pengelola-pengiriman')->with('success', 'Berhasil melakukan request pengiriman');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function update_pesanan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = StatusPesanan::create([
                "data_ekspedisi_id" => $request->data_ekspedisi_id,
                "waktu" => date('Y-m-d H:i:s'),
                "note" => $request->note,
                "status" => $request->status
            ]);

            if (!$data->save()) {
                throw new \Exception("Terjadi kesalahan dalam menyimpan data");
            }

            DB::commit();

            return redirect()->route('pengelola-pengiriman')->with('success', 'Berhasil memperbarui status pengiriman');
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

    // Daftar Pemesanan
    public function daftar_pesanan()
    {
        $title = "daftar pesanan";
        $data = DataEkspedisi::latest()->get();

        return view('back.pages.pengiriman.daftar-pesanan.index', compact('title', 'data'));
    }

    // Pengelola
    public function pengelola_pengiriman()
    {
        $title = "pengelola pengiriman";
        $data = DataEkspedisi::latest()->get();
        $supir = Supir::get();

        return view('back.pages.pengiriman.request-pengiriman.pengelola-pengiriman', compact('title', 'data', 'supir'));
    }
}
