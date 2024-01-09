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
            $data=["izena"=>$datos[0],"abizenak"=>$datos[1],"kodea"=>$datos[2],"sortze_data"=>$datos[3]];
            Langile::insert($data);
           // return "Se ha insertado";
    }

    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Langile::find($datos[0]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Langile::where('id', $datos[0])->update(array('izena' =>$datos[1],'abizenak' =>$datos[2],'kodea' =>$datos[3],'eguneratze_data' =>$datos[4]));
        }
    }

    public function delete($id){
        $belajar = Langile::find($id);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Langile::where('id', $id)->delete();    
        }
    }
}
