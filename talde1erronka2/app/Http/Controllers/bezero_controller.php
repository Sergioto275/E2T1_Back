<?php

namespace App\Http\Controllers;

use App\Models\Bezero;

use Illuminate\Http\Request;

class bezero_controller extends Controller
{
    
    public function getAll()
    {
        $belajar = Bezero::all();
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }

    public function getById($id)
    {
        $belajar = Bezero::find($id);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }

    public function insert(Request $request)
    {
        $datos=$request->all();
            $data=["izena"=>$datos["izena"],"abizena"=>$datos["abizena"],"telefonoa"=>$datos["telefonoa"],"azal_sentikorra"=>$datos["azal_sentikorra"],"sortze_data"=>$datos["sortze_data"]];
            Bezero::insert($data);
            return response('', 201);
    }


    public function update(Request $request)
    {
        $datos = $request->all();
        $belajar = Bezero::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            Bezero::where('id', $datos['id'])->update(array("izena" => $datos["izena"], "abizena" => $datos["abizena"],"telefonoa" => $datos["telefonoa"], "eguneratze_data" => $datos["eguneratze_data"]));
            return response('', 202);
        }

    }

    public function delete(Request $request)
    {
        $datos = $request->all();
        $belajar = Bezero::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Bezero::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
