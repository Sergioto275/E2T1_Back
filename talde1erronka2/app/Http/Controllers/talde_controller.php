<?php

namespace App\Http\Controllers;

use App\Models\talde_model;
use Illuminate\Http\Request;

class talde_controller extends Controller
{
    public function taldeak_kargatu()
    {
        $emaitza = talde_model::all();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados",], 404);
        }
        return response() -> json($emaitza, 200);
    }

    public function taldeak_kargatu_byId($kodea)
    {
        $emaitza = talde_model::where('kodea',$kodea)->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($emaitza, 200);
        }   
    }

    public function taldea_update(Request $request)
    {
        $datos=$request->all();
        $emaitza = talde_model::where('kodea',$datos['kodea'])->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            talde_model::where('kodea', $datos['kodea'])->update(array('izena' =>$datos['izena'],'eguneratze_data' =>$datos['eguneratze_data']));
            return response('', 202);
        }        
    }

    public function taldea_delete(Request $request)
    {
        $datos=$request->all();
        $emaitza = talde_model::where('kodea',$datos['kodea'])->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            talde_model::where('kodea', $datos['kodea'])->update(array('ezabatze_data' =>$datos['ezabatze_data']));
            return response('', 200);
        }        
    }

    public function taldea_insert(Request $request)
    {
        $datos = $request->all();
        $data=["kodea"=>$datos["kodea"],"izena"=>$datos["izena"],"sortze_data"=>$datos["sortze_data"]];
        talde_model::insert($data);
        return response('', 201);
    }
}
