<?php

namespace App\Http\Controllers;
use App\Models\DevolverMaterial;
use Illuminate\Http\Request;

class devolver_controller extends Controller
{
    public function erakutzi(){
        $datos = DevolverMaterial::join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
        ->join('langilea', 'materiala_erabili.id_langilea', '=', 'langilea.id')
        ->select(
            'materiala_erabili.*',
            'materiala.izena as materiala_izena',
            'langilea.izena as langilea_izena'
        )
        ->get();
        if(!$datos){
            return response()->json("No hay datos", 404);
        }else{
            return response()->json($datos, 200);
        }
    }

    public function eguneratu(Request $request){
        $datos=$request->all();
        if(!$datos){
            return response()->json("No hay datos enviados", 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            DevolverMaterial::where('id',$datos['id'])->update(array("id_langilea"=>$datos["id_langilea"],"id_materiala"=>$datos["id_materiala"],"eguneratze_data"=>$eguneratze_data));
            return response()->json("Se ha insertado", 200);
        }
    }

    public function filterbyid($id){
        $datos=DevolverMaterial::find($id);
        if(!$datos){
            return response()->json("NO hay datos con esa id",404);
        }else{
            return response()->json($datos,200);
        }
    }

    public function insertar(Request $request){
        $datos=$request->all();
        DevolverMaterial::insert($datos);
        return response()->json("Se ha insertado",200);
    }

    public function devolver(Request $request){
        $datos=$request->all();
        if(!$datos){
            return response()->json("No han llegado datos",404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $amaiera_data = date("Y-m-d H:i:s");
            DevolverMaterial::where('id',$datos["id"])->update(array("amaiera_data"=>$amaiera_data,"eguneratze_data"=>$amaiera_data));
        }
    }
}
