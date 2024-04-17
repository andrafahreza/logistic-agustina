<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use App\Models\Regencies;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function kecamatan($id = null)
    {
        $data = Regencies::where('province_id', $id)->get();

        $data = [
            "alert" => 1,
            "data" => $data
        ];

        return response()->json($data);
    }

    public function kelurahan($id = null)
    {
        $data = Districts::where('regency_id', $id)->get();

        $data = [
            "alert" => 1,
            "data" => $data
        ];

        return response()->json($data);
    }
}
