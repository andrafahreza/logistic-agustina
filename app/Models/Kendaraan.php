<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table    = 'kendaraan';
    protected $fillable = [
        'id',
        'vendor_id',
        'no_kendaraan',
        'jenis_kendaraan',
        'merk',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class, "vendor_id");
    }
}
