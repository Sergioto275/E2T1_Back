<?php

namespace App\Http\Controllers;

use App\Models\KategoriaTratamendu;
use Illuminate\Http\Request;

class kategoriaTratamendu_controller extends Controller
{
    public function erakutsi()
    {
        $belajar = KategoriaTratamendu::all();
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }

    public function insert(Request $request){
        $datos = $request->all();
        $data = ["izena"=>$datos["izena"],"kolorea"=>$datos["kolorea"],"extra"=>$datos["extra"]];
        KategoriaTratamendu::insert($data);
        return response('', 201);
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = KategoriaTratamendu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            KategoriaTratamendu::where('id', $datos['id'])->update(array('izena'=>$datos["izena"],"kolorea"=>$datos["kolorea"],"extra"=>$datos["extra"],"eguneratze_data"=>$eguneratze_data));
            return response('', 200);
        }
    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = KategoriaTratamendu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            KategoriaTratamendu::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
