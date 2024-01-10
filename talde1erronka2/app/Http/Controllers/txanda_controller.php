<?php

namespace App\Http\Controllers;

use App\Models\txanda_model;
use Illuminate\Http\Request;

class txanda_controller extends Controller
{
    public function txandak_kargatu()
    {
        $emaitza = txanda_model::all();
        $json = json_encode($emaitza);
        return $json;
    }
}
