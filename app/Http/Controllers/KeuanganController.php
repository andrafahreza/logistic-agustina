<?php

namespace App\Http\Controllers;

use App\Models\DataEkspedisi;
use App\Models\PembayaranPelanggan;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class KeuanganController extends Controller
{
    public function laporan_keuangan()
    {
        $title = "laporan keuangan";
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

        return view('back.pages.keuangan.laporan-keuangan', compact("title", "dataTambah", "data"));
    }

    public function simpan_pembayaran_ekspedisi(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = PembayaranPelanggan::create([
                "data_ekspedisi_id" => $request->id,
                "status" => $request->status
            ]);

            if (!$data->save()) {
                throw new \Exception("Terjadi kesalahan saat menyimpan data, silahkan coba lagi");
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

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data pembayaran pelanggan");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function cetak_laporan_keuangan()
    {
        $pembayaran = PembayaranPelanggan::where('status', 'lunas')->latest()->get();
        $pendapatan = 0;
        $pesanan = 0;

        foreach ($pembayaran as $key => $value) {
            $pendapatan += $value->data_ekspedisi->biaya;
            $pesanan ++;
        }

        $data = [
            "pendapatan" => $pendapatan,
            "pesanan" => $pesanan,
            "data" => $pembayaran
        ];

        $pdf = PDF::loadview('back.pages.keuangan.laporan', ['data' => $data]);
        return $pdf->stream('laporan-keuangan');
    }
}
