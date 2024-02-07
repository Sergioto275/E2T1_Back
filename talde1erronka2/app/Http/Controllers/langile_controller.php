<?php

namespace App\Http\Controllers;
use App\Models\Langile;
use Carbon\Carbon;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Langileak",
 *     description="Produktuak kudeatzeko kontroladorea"
 * )
 */
class langile_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/langileak",
     *     tags={"Langileak"},
     *     description="Produktu guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Langile guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du langilerik topatu.")
     * )
     */   
    public function getAll(){
        $belajar = Langile::all();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response() -> json($belajar, 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/langileak/{id}",
     *     tags={"Langileak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Langilearen ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera langile bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako langilea bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du langilerik topatu ID horrekin.")
     * )
     */
    public function getById($id){
        $belajar = Langile::find($id);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }
    }
    /**
     * @OA\Post(
     *     path="/langileak",
     *     tags={"Langileak"},
     *     description="Adierazitako informazioarekin langile berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="izena", type="string", description="Langileen izena"),
     *         @OA\Property(property="abizenak", type="string", description="Langileen abizenak"),
     *         @OA\Property(property="kodea", type="string", description="Langilearen kodea"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Langilearen sortze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Langilea ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
            $datos = $request->all();
            $data = ["izena"=>$datos["izena"],"abizenak"=>$datos["abizenak"],"kodea"=>$datos["kodea"]];
            Langile::insert($data);
            return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/langileak",
     *     tags={"Langileak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Langileen ID-a"),
     *         @OA\Property(property="izena", type="string", description="Langileen izena"),
     *         @OA\Property(property="abizenak", type="string", description="Langileen abizenak"),
     *         @OA\Property(property="kodea", type="string", description="Langilearen kodea"),
     *         @OA\Property(property="eguneratze_data", type="string", format="date-time", description="Langilearen eguneratze-data eta ordua"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera produktu bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Langilea ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du langilerik topatu ID horrekin.")
     * )
     */
    public function update(Request $request){
        $datos=$request->all();
        $belajar = Langile::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Langile::where('id', $datos['id'])->update(array('izena'=>$datos['izena'],'abizenak'=>$datos['abizenak'],'kodea'=>$datos['kodea'],'eguneratze_data'=>$eguneratze_data));
            return response('', 202);
        }
    }
    /**
     * @OA\Get(
     *     path="/langileak/count/{fecha}",
     *     tags={"Langileak"},
     *     @OA\Parameter(
     *         name="fecha",
     *         description="Data bat",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="date")
     *     ),
     *     description="Adierazitako datan zenbat langile dauden bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako langile kantitatea bueltatzen du."),
     * )
     */
    public function langile_count($fecha){
        if($fecha){
            $data = $fecha;
        }else{
            date_default_timezone_set('Europe/Madrid');
            $data =date("Y-m-d");
        }
        $fechaCarbon = Carbon::parse($data);
        $eguna = $fechaCarbon->dayOfWeek;
        $count = Langile::where('kodea', function ($query) use ($data, $eguna) {
            $query->select('kodea')
                ->from('ordutegia')
                ->where('hasiera_data', '<=', $data)
                ->where('amaiera_data', '>=', $data)
                ->where('eguna', '=', $eguna)
                ->where(function ($query) {
                    $query->whereNull('ezabatze_data')
                        ->orWhere('ezabatze_data', '0000-00-00');
                });
        })->count();
        $count--;
        return $count;
    }
    /**
     * @OA\Delete(
     *     path="/langileak",
     *     tags={"Langileak"},
     *     description="Adierazitako ID-a erabilita datubasean langileen ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Langileen ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Langilearen ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Langileak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago langilerik ID horrekin.")
     * )
     */
    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Langile::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Langile::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
