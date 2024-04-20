<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPesanan extends Model
{
    use HasFactory;

    protected $table    = 'status_pesanan';
    protected $fillable = [
        'id',
        'data_ekspedisi_id',
        'waktu',
        'note',
        'status',
    ];

    public function data_ekspedisi(){
        return $this->belongsTo(DataEkspedisi::class, "data_ekspedisi_id");
    }
}
