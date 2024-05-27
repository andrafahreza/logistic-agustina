<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;

    protected $table    = 'biaya';
    protected $fillable = [
        'id',
        'cabang_id',
        'biaya',
        'service',
        'minimal_berat',
        'pengiriman',
        'jangka_waktu',
    ];

    public function cabang(){
        return $this->belongsTo(Cabang::class, "cabang_id");
    }
}
