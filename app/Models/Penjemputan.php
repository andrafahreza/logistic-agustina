<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    use HasFactory;

    protected $table    = 'penjemputan';
    protected $fillable = [
        'id',
        'nama_kurir',
        'alamat_penjemputan',
        'status',
        'bukti_penjemputan',
        'keterangan'
    ];

    public function data_ekspedisi(){
        return $this->hasOne(DataEkspedisi::class, "penjemputan_id", "id");
    }
}
