<?php

namespace App\Http\Controllers;
use App\Models\Kategoria;

use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Kategoriak",
 *     description="Kategoriak kudeatzeko kontroladorea"
 * )
 */
class kategoria_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/kategoriak",
     *     tags={"Kategoriak"},
     *     description="Kategoria guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Kategoria guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du kategoriarik topatu.")
     * )
     */
    public function getAll(){
        $belajar = Kategoria::all();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response() -> json($belajar, 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/kategoriak/{id}",
     *     tags={"Kategoriak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Kategoriaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera kategoria bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako kategoria bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du kategoriarik topatu ID horrekin.")
     * )
     */
    public function getById($id){
        $belajar = Kategoria::find($id);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }   
    }
    /**
     * @OA\Post(
     *     path="/kategoriak",
     *     tags={"Kategoriak"},
     *     description="Adierazitako informazioarekin kategoria berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="izena", type="string", description="Kategoriaren izena"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Kategoriaren sortze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Kategoria ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
            $datos=$request->all();
            $data=["izena"=>$datos["izena"]];
            Kategoria::insert($data);
            return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/kategoriak",
     *     tags={"Kategoriak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Kategoriaren ID-a"),
     *         @OA\Property(property="izena", type="string", description="Kategoriaren izena"),
     *         @OA\Property(property="eguneratze_data", type="string", format="date-time", description="Kategoriaren eguneratze-data eta ordua"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera kategoria bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Kategoria ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du kategoriarik topatu ID horrekin.")
     * )
     */
    public function update(Request $request){
        $datos=$request->all();
        $belajar = Kategoria::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Kategoria::where('id', $datos['id'])->update(array('izena'=>$datos['izena'],'eguneratze_data'=>$eguneratze_data));
            return response('', 202);
        }

    }
    /**
     * @OA\Delete(
     *     path="/kategoriak",
     *     tags={"Kategoriak"},
     *     description="Adierazitako ID-a erabilita datubasean kategoriaren ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Kategoriaren ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Kategoriaren ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Kategoriak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago kategoriarik ID horrekin.")
     * )
     */
    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Kategoria::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Kategoria::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
