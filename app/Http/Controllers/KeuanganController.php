<?php

namespace App\Http\Controllers;

use App\Models\DataEkspedisi;
use App\Models\PembayaranPelanggan;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function hutang_piutang()
    {
        $title = "hutang & piutang";
        $getData = DataEkspedisi::latest()->get();

        $dataTambah = array();
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

            if ($value->pembayaran_pelanggan->count() > 0) {
                continue;
            }

            $dataTambah[] = $value;
        }

        $data = PembayaranPelanggan::latest()->get();

        return view('back.pages.keuangan.hutang-piutang', compact("title", "dataTambah", "data"));
    }

    public function simpan_pembayaran_ekspedisi(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = PembayaranPelanggan::where('data_ekspedisi_id', $request->id)->first();
            if (!empty($data)) {
                throw new \Exception("Data pembayaran dengan no awp tersebut sudah pernah ditambahkan");
            }

            $data = PembayaranPelanggan::create([
                "data_ekspedisi_id" => $request->id,
                "status" => "process"
            ]);

            if (!$data->save()) {
                throw new \Exception("Terjadi kesalahan saat menyimpan data, silahkan coba lagi");
            }

            $statusPesanan = StatusPesanan::create([
                "data_ekspedisi_id" => $request->id,
                "waktu" => date('Y-m-d H:i:s'),
                "note" => "Menunggu Pembayaran Pelanggan",
                "status" => "process"
            ]);

            if (!$statusPesanan->save()) {
                throw new \Exception("Terjadi kesalahan saat menyimpan status, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menambah data pembayaran pelanggan");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus_pembayaran_ekspedisi(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = PembayaranPelanggan::find($request->id);
            if (empty($data)) {
                throw new \Exception("Data Pembayaran tidak ditemukan");
            }

            $data_ekspedisi_id = $data->data_ekspedisi_id;
            if ($data->status == "done") {
                throw new \Exception("Tidak dapat mengapus data pembayaran yang sudah dibayarkan");
            }

            if (!$data->delete()) {
                throw new \Exception("Terjadi kesalahan saat menghapus data pembayaran, silahkan coba lagi");
            }

            $statusPesanan = StatusPesanan::where('data_ekspedisi_id', $data_ekspedisi_id)
            ->where('note', 'Menunggu Pembayaran Pelanggan')
            ->first();

            if (!$statusPesanan->delete()) {
                throw new \Exception("Terjadi kesalahan saat menghapus status pesanan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data pembayaran pelanggan");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
