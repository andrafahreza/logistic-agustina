<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    use HasFactory;

    protected $table    = 'supir';
    protected $fillable = [
        'id',
        'nama',
        'sim',
        'alamat'
    ];

    public function data_ekspedisi(){
        return $this->hasOne(DataEkspedisi::class, "supir_id", "id");
    }
}
