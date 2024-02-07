<?php

namespace App\Http\Controllers;
use App\Models\DevolverMaterial;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Materiala bueltatu",
 *     description="Materiala bueltatzeko kontroladora"
 * )
 */
class devolver_controller extends Controller
{   
    /**
    * @OA\Get(
    *     path="/devolver",
    *     tags={"Materiala bueltatu"},
    *     description="Materiala_erabiliko erregistro guztiak bueltatzen ditu.",
    *     @OA\Response(response="200", description="Erregistro guztiak bueltatu ditu."),
    *     @OA\Response(response="404", description="Ez du erregistrorik topatu.")
    * )
    */
    public function erakutsi(){
        $datos = DevolverMaterial::join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
        ->join('langilea', 'materiala_erabili.id_langilea', '=', 'langilea.id')
        ->select(
            'materiala_erabili.*',
            'materiala.izena as materiala_izena',
            'langilea.izena as langilea_izena'
        )
        ->get();
        if(!$datos){
            return response()->json("No hay datos", 404);
        }else{
            return response()->json($datos, 200);
        }
    }
    /**
     * @OA\Put(
     *     path="/devolver",
     *     tags={"Materiala bueltatu"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Jarduera ID-a"),
     *         @OA\Property(property="id_langilea", type="integer", description="Langilearen ID-a"),
     *         @OA\Property(property="id_materiala", type="integer", description="Materialaren ID-a"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera produktu bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Produktua ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du produkturik topatu ID horrekin.")
     * )
     */
    public function eguneratu(Request $request){
        $datos=$request->all();
        if(!$datos){
            return response()->json("No hay datos enviados", 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            DevolverMaterial::where('id',$datos['id'])->update(array("id_langilea"=>$datos["id_langilea"],"id_materiala"=>$datos["id_materiala"],"eguneratze_data"=>$eguneratze_data));
            return response()->json("Se ha actualizado", 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/devolver/{id}",
     *     tags={"Materiala bueltatu"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Erregistroaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera erregistro bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako erregistroa bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du erregistrorik topatu ID horrekin.")
     * )
     */
    public function filterbyid($id){
        $datos=DevolverMaterial::find($id);
        if(!$datos){
            return response()->json("NO hay datos con esa id",404);
        }else{
            return response()->json($datos,200);
        }
    }
    /**
     * @OA\Post(
     *     path="/devolver",
     *     tags={"Materiala bueltatu"},
     *     description="Adierazitako informazioarekin erregistro berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id_materiala", type="integer", description="Materialaren ID-a"),
     *         @OA\Property(property="id_langilea", type="integer", description="Langilearen ID-a"),
     *         @OA\Property(property="hasiera_data", type="string", format="date-time", description="Jardueraren hasierako data eta ordua"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Jardueraren sortze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Produktua ondo txertatu da datubasean.")
     * )
     */
    public function insertar(Request $request){
        $datos=$request->all();
        DevolverMaterial::insert($datos);
        return response()->json("Se ha insertado",200);
    }
}
