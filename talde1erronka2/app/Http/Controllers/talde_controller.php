<?php

namespace App\Http\Controllers;

use App\Models\Taldea;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Taldeak",
 *     description="Taldeak kudeatzeko kontroladorea"
 * )
 */
class talde_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/taldeak",
     *     tags={"Taldeak"},
     *     description="Talde guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Talde guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du talderik topatu.")
     * )
     */
    public function getAll()
    {
        $emaitza = Taldea::all();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados",], 404);
        }
        return response() -> json($emaitza, 200);
    }
    /**
     * @OA\Get(
     *     path="/taldeak/{id}",
     *     tags={"Taldeak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Taldearen ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera talde bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako taldea bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du talderik topatu ID horrekin.")
     * )
     */
    public function getById($kodea)
    {
        $emaitza = Taldea::where('kodea',$kodea)->get();
        if(!$emaitza){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($emaitza, 200);
        }   
    }
    /**
     * @OA\Put(
     *     path="/taldeak",
     *     tags={"taldeak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="kodea", type="string", description="Taldearen kodea"),
     *         @OA\Property(property="izena", type="string", description="Taldearen izena"),
     *         @OA\Property(property="eguneratze_data", type="string", format="date-time", description="Taldearen eguneratze-data eta ordua"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera talde bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Taldea ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du talderik topatu ID horrekin.")
     * )
     */
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
    /**
     * @OA\Delete(
     *     path="/taldeak",
     *     tags={"Taldeak"},
     *     description="Adierazitako ID-a erabilita datubasean taldeen ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Ezabatzeko taldearen ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Taldeak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago talderik ID horrekin.")
     * )
     */
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
    /**
     * @OA\Post(
     *     path="/taldeak",
     *     tags={"Taldeak"},
     *     description="Adierazitako informazioarekin talde berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="kodea", type="string", description="Taldearen kodea"),
     *         @OA\Property(property="izena", type="string", description="Taldearen izena"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Taldearen sortze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Taldea ondo txertatu da datubasean.")
     * )
     */
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
