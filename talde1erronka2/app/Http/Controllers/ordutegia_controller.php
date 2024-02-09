<?php

namespace App\Http\Controllers;

use App\Models\Ordutegia;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Ordutegiak",
 *     description="Ordutegiak kudeatzeko kontroladorea"
 * )
 */
class ordutegia_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/ordutegiak",
     *     tags={"Ordutegiak"},
     *     description="Ordutegi guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Ordutegi guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du ordutegirik topatu.")
     * )
     */
    public function getAll(){
        $belajar = Ordutegia::all();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados",], 404);
        } else{
            return response() -> json($belajar, 200);        
        }
    }
    /**
     * @OA\Get(
     *     path="/ordutegiak/{id}",
     *     tags={"Ordutegiak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Ordutegiaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera ordutegi bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako ordutegia bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du ordutegirik topatu ID horrekin.")
     * )
     */
    public function getById($id){
        $belajar = Ordutegia::where('id',$id)->get();
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }   
    }
    /**
     * @OA\Post(
     *     path="/ordutegiak",
     *     tags={"Ordutegiak"},
     *     description="Adierazitako informazioarekin ordutegi berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="kodea", type="string", description="Taldearen kodea"),
     *         @OA\Property(property="eguna", type="integer", description="Ordutegiaren eguna (1-7)"),
     *         @OA\Property(property="hasiera_data", type="string", format="date", description="Ordutegiaren hasierako data"),
     *         @OA\Property(property="amaiera_data", type="string", format="date", description="Ordutegiaren amaierako data"),
     *         @OA\Property(property="hasiera_ordua", type="string", format="time", description="Ordutegiaren hasierako ordua"),
     *         @OA\Property(property="amaiera_ordua", type="string", format="time", description="Ordutegiaren amaierako ordua"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Ordutegiaren sortze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Ordutegia ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
        $datos=$request->all();
        $belajar = Ordutegia::where('eguna', $datos["eguna"])
        ->where(function ($query) use ($datos) {
            // Check for non-overlapping date ranges
            $query->where('amaiera_data', '<=', $datos["hasiera_data"])
                ->where('hasiera_data', '>=', $datos["amaiera_data"]);
        })
        ->get();
            if(count($belajar)>0){
                return response()->json(['Error' => "Ya hay un grupo este dia",], 404);
            }
            $data=["kodea"=>$datos["kodea"],"eguna"=>$datos["eguna"],"hasiera_data"=>$datos["hasiera_data"],"amaiera_data"=>$datos["amaiera_data"],"hasiera_ordua"=>$datos["hasiera_ordua"],"amaiera_ordua"=>$datos["amaiera_ordua"]];
            Ordutegia::insert($data);   
            return response('', 201);
    
    }
    /**
     * @OA\Put(
     *     path="/ordutegiak",
     *     tags={"Ordutegiak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Ordutegiaren ID-a"),
     *         @OA\Property(property="kodea", type="string", description="Taldearen kodea"),
     *         @OA\Property(property="eguna", type="integer", description="Ordutegiaren eguna (1-7)"),
     *         @OA\Property(property="hasiera_data", type="string", format="date", description="Ordutegiaren hasierako data"),
     *         @OA\Property(property="amaiera_data", type="string", format="date", description="Ordutegiaren amaierako data"),
     *         @OA\Property(property="hasiera_ordua", type="string", format="time", description="Ordutegiaren hasierako ordua"),
     *         @OA\Property(property="amaiera_ordua", type="string", format="time", description="Ordutegiaren amaierako ordua"),
     *         @OA\Property(property="eguneratze_data", type="string", format="date-time", description="Ordutegiaren eguneratze-data eta ordua"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera ordutegi bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Ordutegia ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du ordutegirik topatu ID horrekin.")
     * )
     */
    public function update(Request $request){
        
        $datos=$request->all();
        $belajar = Ordutegia::find($datos["id"]);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Ordutegia::where('id', $datos['id'])->update(array('kodea' =>$datos['kodea'],'eguna' =>$datos['eguna'],'hasiera_data' =>$datos['hasiera_data'],'amaiera_data' =>$datos['amaiera_data'],'hasiera_ordua' =>$datos['hasiera_ordua' ],'amaiera_ordua' =>$datos['amaiera_ordua'],'eguneratze_data' =>$eguneratze_data));
            return response('', 202);
        }
    }
    /**
     * @OA\Delete(
     *     path="/ordutegiak",
     *     tags={"Ordutegiak"},
     *     description="Adierazitako ID-a erabilita datubasean ordutegien ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Ezabatzeko ordutegiaren ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Ordutegiak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago ordutegirik ID horrekin.")
     * )
     */
    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Ordutegia::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Ordutegia::where('id', $datos['id'])->update(array('ezabatze_data' =>$ezabatze_data));
            return response('', 200);
        }
    }
}
