<?php

namespace App\Http\Controllers;

use App\Models\Ordutegia;
use Illuminate\Http\Request;

class ControladorOrdutegia extends Controller
{
    public function erakutzi(){
        $belajar = Ordutegia::all();
        $json= json_encode($belajar);
        return $json;
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
            $data=["kodea"=>$datos[0],"eguna"=>$datos[1],"hasiera_data"=>$datos[2],"amaiera_data"=>$datos[3],"hasiera_ordua"=>$datos[4],"amaiera_ordua"=>$datos[5]];
            Ordutegia::insert($data);
           // return "Se ha insertado";
    }

    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Ordutegia::find($datos[0]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Ordutegia::where('id', $datos[0])->update(array('kodea' =>$datos[1],'eguna' =>$datos[2],'hasiera_data' =>$datos[3],'amaiera_data' =>$datos[4],'hasiera_ordua' =>$datos[5],'amaiera_ordua' =>$datos[6],'eguneratze_data' =>$datos[7]));
        }
    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Ordutegia::find($datos[0]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Ordutegia::where('id', $datos[0])->update(array('kodea' =>$datos[1],'eguna' =>$datos[2],'hasiera_data' =>$datos[3],'amaiera_data' =>$datos[4],'hasiera_ordua' =>$datos[5],'amaiera_ordua' =>$datos[6],'ezabatze_data' =>$datos[7]));
        }
    }
}
