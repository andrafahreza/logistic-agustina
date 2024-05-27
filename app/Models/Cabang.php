<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $table    = 'cabang';
    protected $fillable = [
        'id',
        'nama_cabang',
    ];

    public function data_ekspedisi(){
        return $this->hasMany(DataEkspedisi::class, "cabang_id", "id");
    }

    public function biaya() {
        return $this->hasOne(Biaya::class, "cabang_id", "id");
    }
}
