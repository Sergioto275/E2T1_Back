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

    public function insert(Request $request){
        $datos=$request->all();
        Tratamenduak::insert(array('izena'=>$datos["izena"],"etxeko_prezioa"=>$datos["etxeko_prezioa"],"kanpoko_prezioa"=>$datos["kanpoko_prezioa"]));
        return response('', 201);
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = Tratamenduak::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Tratamenduak::where('id', $datos['id'])->update(array('izena'=>$datos["izena"],"etxeko_prezioa"=>$datos["etxeko_prezioa"],"kanpoko_prezioa"=>$datos["kanpoko_prezioa"],"eguneratze_data"=>$eguneratze_data));
            return response('', 200);
        }
    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Tratamenduak::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Tratamenduak::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
