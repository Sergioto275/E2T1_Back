<?php

namespace App\Http\Controllers;

use App\Models\Kolore_historiala;

use Illuminate\Http\Request;

class kolore_histroriala_controller extends Controller
{
    
    public function getAll()
    {
        $belajar = Kolore_historiala::join('produktua', 'kolore_historiala.id_produktua', '=', 'produktua.id')
                            ->select('kolore_historiala.*', 'produktua.izena as produktua_izena','produktua.marka as produktua_marka')
                            ->get();

        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
        
    }

    public function getById($id)
    {
        $belajar = Kolore_historiala::join('produktua', 'kolore_historiala.id_produktua', '=', 'produktua.id')
                            ->select('kolore_historiala.*', 'produktua.izena as produktua_izena','produktua.marka as produktua_marka')
                            ->where('kolore_historiala.id', $id)
                            ->get();

        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }

    public function insert(Request $request)
    {
        date_default_timezone_set('Europe/Madrid');
        $sortze_data = date("Y-m-d H:i:s");
        $datos=$request->all();
            $data=["id_bezeroa"=>$datos["id_bezeroa"],"id_produktua"=>$datos["id_produktua"],"data"=>$datos["data"],"kantitatea"=>$datos["kantitatea"],"bolumena"=>$datos["bolumena"],"oharrak"=>$datos["oharrak"],"sortze_data"=>$sortze_data];
            Kolore_historiala::insert($data);
            return response('', 201);
    }


    public function update(Request $request)
    {
        $datos = $request->all();
        $belajar = Kolore_historiala::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Kolore_historiala::where('id', $datos['id'])->update(array("id_bezeroa"=>$datos["id_bezeroa"],"id_produktua"=>$datos["id_produktua"],"data"=>$datos["data"],"kantitatea"=>$datos["kantitatea"],"bolumena"=>$datos["bolumena"],"oharrak"=>$datos["oharrak"],"eguneratze_data"=>$eguneratze_data));
            return response('', 202);
        }

    }

    public function delete(Request $request)
    {
        $datos = $request->all();
        $belajar = Kolore_historiala::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Kolore_historiala::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
