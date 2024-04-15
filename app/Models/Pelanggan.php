<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table    = 'pelanggan';
    protected $fillable = [
        'id',
        'nomor_bisnis',
        'npwp',
        'jenis_usaha',
        'alamat',
        'no_fax',
    ];

    public function user(){
        return $this->belongsTo(User::class, "pelanggan_id");
    }
}
