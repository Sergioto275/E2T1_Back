<?php

namespace App\Http\Controllers;
use App\Models\Produktua;
use App\Models\Kategoria;


use Illuminate\Http\Request;

class produktua_controller extends Controller
{
    public function getAll(){
        $belajar = Produktua::join('kategoria', 'produktua.id_kategoria', '=', 'kategoria.id')
                            ->select('produktua.*', 'kategoria.izena as kategoria_izena')
                            ->get();
    
        if($belajar->isEmpty()){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response()->json($belajar, 200);
        }
    }    

    public function getById($id){
        $belajar = Produktua::join('kategoria', 'produktua.id_kategoria', '=', 'kategoria.id')
                            ->select('produktua.*', 'kategoria.izena as kategoria_izena')
                            ->where('produktua.id', $id)
                            ->get();        
        
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }   
    }

    public function insert(Request $request){
            $datos=$request->all();
            $data=["izena"=>$datos["izena"],
                "deskribapena"=>$datos["deskribapena"],
                "id_kategoria"=>$datos["id_kategoria"],
                "marka"=>$datos["marka"],
                "stock" => $datos["stock"],
                "stock_alerta" => $datos["stock_alerta"], 
                "sortze_data"=>$datos["sortze_data"]];
            Produktua::insert($data);
            return response('', 201);
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = Produktua::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            Produktua::where('id', $datos['id'])->update(array("izena"=>$datos["izena"],"deskribapena"=>$datos["deskribapena"],"id_kategoria"=>$datos["id_kategoria"],"marka"=>$datos["marka"],"stock" => $datos["stock"],"stock_alerta" => $datos["stock_alerta"],'eguneratze_data'=>$datos['eguneratze_data']));
            return response('', 202);
        }

    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Produktua::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            Produktua::where('id', $datos['id'])->update(array('ezabatze_data'=>$datos['ezabatze_data']));
            return response('', 200);
        }
    }
}
