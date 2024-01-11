<?php

namespace App\Http\Controllers;
use App\Models\Langile;

use Illuminate\Http\Request;

class ControladorLangile extends Controller
{
    public function erakutzi(){
        $belajar = Langile::all();
        $json= json_encode($belajar);
        return $json;
    }

    public function erakutzibyid($id){
        $belajar = Langile::where('id',$id)->get();
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            return response()->json($belajar);
        }   
    }

    public function insert(Request $request){
            $datos=$request->all();
            $data=["izena"=>$datos["izena"],"abizenak"=>$datos["abizenak"],"kodea"=>$datos["kodea"],"sortze_data"=>$datos["sortze_data"]];
            Langile::insert($data);
           // return "Se ha insertado";
    }

    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Langile::find($datos['id']);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Langile::where('id', $datos['id'])->update(array('izena'=>$datos['izena'],'abizenak'=>$datos['abizenak'],'kodea'=>$datos['kodea'],'eguneratze_data'=>$datos['eguneratze_data']));
        }
    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Langile::find($datos[0]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Langile::where('id', $datos['id'])->update(array('ezabatze_data'=>$datos['ezabatze_data']));
        }
    }
}
