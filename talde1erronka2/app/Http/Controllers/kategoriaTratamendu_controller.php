<?php

namespace App\Http\Controllers;

use App\Models\KategoriaTratamendu;
use Illuminate\Http\Request;

class kategoriaTratamendu_controller extends Controller
{
    public function erakutzi()
    {
        $belajar = KategoriaTratamendu::all();
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }}
