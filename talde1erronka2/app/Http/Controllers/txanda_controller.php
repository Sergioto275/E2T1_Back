<?php

namespace App\Http\Controllers;
use App\Models\Txanda;

use Illuminate\Http\Request;

class txanda_controller extends Controller
{
    public function getAll(){
        $belajar = Txanda::all();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados",], 404);
        } else{
            return response() -> json($belajar, 200);
        }
    }

    public function getById($id){
        $belajar = Txanda::find($id);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }   
    }

    public function insert(Request $request){
            $datos=$request->all();
            $data=["mota"=>$datos["mota"],"data"=>$datos["data"],"id_langilea"=>$datos["id_langilea"],"sortze_data"=>$datos["sortze_data"]];
            Txanda::insert($data);
            return response('', 201);
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = Txanda::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            Txanda::where('id', $datos['id'])->update(array("mota"=>$datos["mota"],"id_langilea"=>$datos["id_langilea"],"eguneratze_data"=>$datos["eguneratze_data"]));
            return response('', 202);
        }

    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Txanda::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            Txanda::where('id', $datos['id'])->update(array('ezabatze_data'=>$datos['ezabatze_data']));
            return response('', 200);
        }
    }
}
