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
            $data=["izena"=>$datos[0],"abizenak"=>$datos[1],"kodea"=>$datos[2],"sortze_data"=>$datos[3]];
            Ordutegia::insert($data);
           // return "Se ha insertado";
    }

    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Ordutegia::find($datos[0]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Ordutegia::where('id', $datos[0])->update(array('izena' =>$datos[1],'abizenak' =>$datos[2],'kodea' =>$datos[3],'eguneratze_data' =>$datos[4]));
        }
    }

    public function delete($id){
        $belajar = Ordutegia::find($id);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Ordutegia::where('id', $id)->delete();    
        }
    }
}
