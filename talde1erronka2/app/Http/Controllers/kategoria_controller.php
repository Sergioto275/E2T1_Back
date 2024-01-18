<?php

namespace App\Http\Controllers;
use App\Models\Kategoria;

use Illuminate\Http\Request;

class kategoria_controller extends Controller
{
    public function getAll(){
        $belajar = Kategoria::all();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response() -> json($belajar, 200);
        }
    }

    public function getById($id){
        $belajar = Kategoria::find($id);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }   
    }

    public function insert(Request $request){
            $datos=$request->all();
            $data=["izena"=>$datos["izena"],"sortze_data"=>$datos["sortze_data"]];
            Kategoria::insert($data);
            return response('', 201);
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = Kategoria::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            Kategoria::where('id', $datos['id'])->update(array('izena'=>$datos['izena'],'eguneratze_data'=>$datos['eguneratze_data']));
            return response('', 202);
        }

    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Kategoria::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            Kategoria::where('id', $datos['id'])->update(array('ezabatze_data'=>$datos['ezabatze_data']));
            return response('', 200);
        }
    }
}
