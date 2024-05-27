<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEkspedisi extends Model
{
    use HasFactory;

    protected $table    = 'data_ekspedisi';
    protected $fillable = [
        'id',
        'supir_id',
        'penjemputan_id',
        'cabang_id',
        'no_resi',
        'nama_asal',
        'nama_penerima',
        'alamat_asal',
        'alamat_penerima',
        'nama_barang',
        'jumlah_barang',
        'volume',
        'note',
        'biaya',
        'created_by',
    ];

    public function supir(){
        return $this->belongsTo(Supir::class, "supir_id");
    }

    public function user_create(){
        return $this->belongsTo(User::class, "created_by");
    }

    public function penjemputan(){
        return $this->belongsTo(Penjemputan::class, "penjemputan_id");
    }

    public function cabang(){
        return $this->belongsTo(Penjemputan::class, "penjemputan_id");
    }

    public function status(){
        return $this->hasMany(StatusPesanan::class, "data_ekspedisi_id", "id");
    }

    public function pembayaran_pelanggan(){
        return $this->hasMany(PembayaranPelanggan::class, "data_ekspedisi_id", "id");
    }
}
