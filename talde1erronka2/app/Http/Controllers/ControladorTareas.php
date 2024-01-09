<?php

namespace App\Http\Controllers;
use App\Models\Tareas;

use Illuminate\Http\Request;

class ControladorTareas extends Controller
{
    public function erakutzi(){
        $belajar = Tareas::all();
        $json= json_encode($belajar);
        return $json;
    }

    public function erakutzibyid($id){
        $belajar = Tareas::where($id);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            return response()->json($belajar);
        }   
    }

    public function insert(Request $request){
            $datos=$request->all();

            Tareas::insert($datos);
           // return "Se ha insertado";
    }

    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Tareas::find($datos["id"]);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Tareas::where('id', $datos["id"])->update(array('izena' =>$datos["izena"],'izen_zientifikoa' =>$datos["izen_zientifikoa"],'pisua' =>$datos["pisua"],'tamaina' =>$datos["tamaina"]));
        }
    }

    public function delete($id){
        $belajar = Tareas::find($id);
        if(!$belajar){
            return response()->json(['errors' => "No existe",], 404);
        }else{
            Tareas::where('id', $id)->delete();    
        }
    }
}
