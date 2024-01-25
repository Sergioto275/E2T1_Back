<?php

namespace App\Http\Controllers;

use App\Models\Tratamenduak;
use Illuminate\Http\Request;

class tratamenduak_controller extends Controller
{
    public function erakutzi(){
        $datuak = Tratamenduak::all();
        if(!$datuak){
            return response()->json(["Error"=>"Errorea egon da eskaera egiterakoan",404]);
        }else{
            return response() -> json($datuak, 200);
        }
    }
}
