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
        'kendaraan_id',
        'supir_id',
        'district_id',
        'no_awb',
        'nama_penerima',
        'alamat_asal',
        'alamat_penerima',
        'nama_barang',
        'jumlah_barang',
        'volume',
        'note',
        'biaya',
        'file_surat_pengiriman',
        'file_awb',
        'created_by',
    ];

    public function kendaraan(){
        return $this->belongsTo(Kendaraan::class, "kendaraan_id");
    }

    public function supir(){
        return $this->belongsTo(Supir::class, "supir_id");
    }

    public function user_create(){
        return $this->belongsTo(User::class, "created_by");
    }

    public function status(){
        return $this->hasMany(StatusPesanan::class, "data_ekspedisi_id");
    }
}
