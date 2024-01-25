<?php

namespace App\Http\Controllers;
use App\Models\Langile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class langile_controller extends Controller
{
    
    public function getAll(){
        $belajar = Langile::all();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response() -> json($belajar, 200);
        }
    }

    public function getById($id){
        $belajar = Langile::find($id);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }
    }

    public function insert(Request $request){
            $datos = $request->all();
            $data = ["izena"=>$datos["izena"],"abizenak"=>$datos["abizenak"],"kodea"=>$datos["kodea"]];
            Langile::insert($data);
            return response('', 201);
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = Langile::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Langile::where('id', $datos['id'])->update(array('izena'=>$datos['izena'],'abizenak'=>$datos['abizenak'],'kodea'=>$datos['kodea'],'eguneratze_data'=>$eguneratze_data));
            return response('', 202);
        }

    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Langile::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Langile::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
