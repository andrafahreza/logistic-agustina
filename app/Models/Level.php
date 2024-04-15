<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table    = 'level';
    protected $fillable = [
        'id',
        'nama_level'
    ];

    public function user(){
        return $this->hasMany(User::class, "level_id");
    }
}
