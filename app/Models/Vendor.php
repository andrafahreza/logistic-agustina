<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table    = 'vendor';
    protected $fillable = [
        'id',
        'kode',
        'no_ktp'
    ];

    public function user(){
        return $this->hasOne(User::class, "vendor_id", "id");
    }
}
