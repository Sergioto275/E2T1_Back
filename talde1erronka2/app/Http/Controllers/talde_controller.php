<?php

namespace App\Http\Controllers;

use App\Models\Taldea;
use Illuminate\Http\Request;

class talde_controller extends Controller
{
    public function getAll()
    {
        $emaitza = Taldea::all();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados",], 404);
        }
        return response() -> json($emaitza, 200);
    }

    public function getById($kodea)
    {
        $emaitza = Taldea::where('kodea',$kodea)->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($emaitza, 200);
        }   
    }

    public function update(Request $request)
    {
        $datos=$request->all();
        $emaitza = Taldea::where('kodea',$datos['kodea'])->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Taldea::where('kodea', $datos['kodea'])->update(array('izena' =>$datos['izena'],'eguneratze_data' =>$eguneratze_data));
            return response('', 202);
        }        
    }

    public function delete(Request $request)
    {
        $datos=$request->all();
        $emaitza = Taldea::where('kodea',$datos['kodea'])->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID"], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Taldea::where('kodea', $datos['kodea'])->update(array('ezabatze_data' =>$ezabatze_data));
            return response('', 200);
        }        
    }

    public function insert(Request $request)
    {
        $datos = $request->all();
        $data=["kodea"=>$datos["kodea"],"izena"=>$datos["izena"]];
        $emaitza = Taldea::where('kodea', $datos['kodea']) -> get();
        if ($emaitza->isEmpty()) {
            Taldea::insert($data);
            return response('', 201);
        } else {
            return response()->json(['Error' => "Kodea repetido"], 409);
        }
    }
}
