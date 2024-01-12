<?php

namespace App\Http\Controllers;

use App\Models\Ordutegia;
use Illuminate\Http\Request;

class ControladorOrdutegia extends Controller
{
    public function erakutzi(){
        $belajar = Ordutegia::all();
        return response() -> json($belajar, 200);
    }

    public function erakutzibyid($id){
        $belajar = Ordutegia::where('id',$id)->get();
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            return response()->json($belajar);
        }   
    }

    public function insert(Request $request){
        $datos=$request->all();
        $data=["kodea"=>$datos["kodea"],"eguna"=>$datos["eguna"],"hasiera_data"=>$datos["hasiera_data"],"amaiera_data"=>$datos["amaiera_data"],"hasiera_ordua"=>$datos["hasiera_ordua"],"amaiera_ordua"=>$datos["amaiera_ordua"],"sortze_data" =>$datos["sortze_data"]];
        Ordutegia::insert($data);
        return response('', 201);
    }

    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Ordutegia::find($datos["id"]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Ordutegia::where('id', $datos['id'])->update(array('kodea' =>$datos['kodea'],'eguna' =>$datos['eguna'],'hasiera_data' =>$datos['hasiera_data'],'amaiera_data' =>$datos['amaiera_data'],'hasiera_ordua' =>$datos['hasiera_ordua' ],'amaiera_ordua' =>$datos['amaiera_ordua'],'eguneratze_data' =>$datos['eguneratze_data']));
            return response('', 202);
        }
    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Ordutegia::find($datos['id']);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Ordutegia::where('id', $datos['id'])->update(array('ezabatze_data' =>$datos['ezabatze_data']));
            return response('', 200);
        }
    }
}
