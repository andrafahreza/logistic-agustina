<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranVendor extends Model
{
    use HasFactory;

    protected $table    = 'pembayaran_vendor';
    protected $fillable = [
        'id',
        'data_ekspedisi_id',
        'bukti',
        'status',
    ];
}
