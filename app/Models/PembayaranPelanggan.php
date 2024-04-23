<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPelanggan extends Model
{
    use HasFactory;

    protected $table    = 'pembayaran_pelanggan';
    protected $fillable = [
        'id',
        'data_ekspedisi_id',
        'status',
    ];

    public function data_ekspedisi(){
        return $this->belongsTo(DataEkspedisi::class, "data_ekspedisi_id");
    }
}
