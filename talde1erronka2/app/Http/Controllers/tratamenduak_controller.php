<?php

namespace App\Http\Controllers;

use App\Models\Langile;
use App\Models\Tratamenduak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Tag(
 *     name="Tratamenduak",
 *     description="Tratamenduak kudeatzeko kontroladorea"
 * )
 */
class tratamenduak_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/tratamenduak",
     *     tags={"Tratamenduak"},
     *     description="Tratamendu guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Tratamendu guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du tratamendurik topatu.")
     * )
     */
    public function erakutsi(){
        $datuak = Tratamenduak::all();
        if(!$datuak){
            return response()->json(["Error"=>"Errorea egon da eskaera egiterakoan",404]);
        }else{
            return response() -> json($datuak, 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/tratamenduByLangile/{group}",
     *     tags={"Tratamenduak"},
     *     @OA\Parameter(
     *         name="group",
     *         description="Taldearen ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera langileak bueltatzen bueltatzen ditu tratamendutan bereizita.",
     *     @OA\Response(response="200", description="Aukeratutako guztia bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du ezer topatu ID horrekin.")
     * )
     */
    public function tratamientos_groupby_langile($grupo){
        $resultados = Langile::leftJoin('hitzordua', function ($join) {
                $join->on('langilea.id', '=', 'hitzordua.id_langilea')
                    ->where(function ($query) {
                        $query->whereNull('langilea.ezabatze_data')
                            ->orWhere('langilea.ezabatze_data', '0000-00-00 00:00:00');
                    })
                    ->where(function ($query) {
                        $query->whereNull('hitzordua.ezabatze_data')
                            ->orWhere('hitzordua.ezabatze_data', '0000-00-00 00:00:00');
                    });
            })
            ->leftJoin('ticket_lerroa', function ($join) {
                $join->on('hitzordua.id', '=', 'ticket_lerroa.id_hitzordua')
                    ->whereNull('ticket_lerroa.ezabatze_data')
                    ->orWhere('ticket_lerroa.ezabatze_data', '0000-00-00 00:00:00');
            })
            ->leftJoin('tratamendua', function ($join) {
                $join->on('ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
                    ->whereNull('tratamendua.ezabatze_data')
                    ->orWhere('tratamendua.ezabatze_data', '0000-00-00 00:00:00');
            })
            ->leftJoin('kategoria_tratamendu', function ($join) {
                $join->on('tratamendua.id_katTratamendu', '=', 'kategoria_tratamendu.id')
                    ->whereNull('kategoria_tratamendu.ezabatze_data')
                    ->orWhere('kategoria_tratamendu.ezabatze_data', '0000-00-00 00:00:00');
            })
            ->where('langilea.kodea', '=', $grupo)
            ->select('langilea.id as langile_id', 'langilea.izena as langile_izena','kategoria_tratamendu.id as kategoria_id' ,'kategoria_tratamendu.izena as kategoria_izena', DB::raw('count(kategoria_tratamendu.id) as cant'))
            ->groupBy('langilea.id', 'langilea.izena', 'kategoria_tratamendu.id', 'kategoria_tratamendu.izena')
            ->get();
        if (!$resultados) {
            return response()->json(["Error" => "Errorea egon da eskaera egiterakoan", 404]);
        } else {
            return response()->json($resultados, 200);
        }
    }
    /**
     * @OA\Post(
     *     path="/tratamenduak",
     *     tags={"Tratamenduak"},
     *     description="Adierazitako informazioarekin tratamendu berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="izena", type="string", description="Tratamenduaren izena"),
     *         @OA\Property(property="etxeko_prezioa", type="integer", description="Etxeko prezioa"),
     *         @OA\Property(property="kanpoko_prezioa", type="integer", description="Kanpoko prezioa"),
     *         @OA\Property(property="id_katTratamendu", type="integer", description="Tratamenduaren kategoria ID-a"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Tratamendua ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
        $datos=$request->all();
        Tratamenduak::insert(array('izena'=>$datos["izena"],"etxeko_prezioa"=>$datos["etxeko_prezioa"],"kanpoko_prezioa"=>$datos["kanpoko_prezioa"],"id_katTratamendu"=>$datos["id_katTratamendu"]));
        return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/tratamenduak",
     *     tags={"Tratamenduak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Tratamenduaren ID-a"),
     *         @OA\Property(property="izena", type="string", description="Tratamenduaren izena"),
     *         @OA\Property(property="etxeko_prezioa", type="integer", description="Etxeko prezioa"),
     *         @OA\Property(property="kanpoko_prezioa", type="integer", description="Kanpoko prezioa"),
     *         @OA\Property(property="id_katTratamendu", type="integer", description="Tratamenduaren kategoria ID-a"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera tratamendu bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Tratamendua ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du tratamendurik topatu ID horrekin.")
     * )
     */
    public function update(Request $request){
        $datos=$request->all();
        $belajar = Tratamenduak::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Tratamenduak::where('id', $datos['id'])->update(array('izena'=>$datos["izena"],"etxeko_prezioa"=>$datos["etxeko_prezioa"],"kanpoko_prezioa"=>$datos["kanpoko_prezioa"],"id_katTratamendu"=>$datos["id_katTratamendu"],"eguneratze_data"=>$eguneratze_data));
            return response('', 200);
        }
    }
    /**
     * @OA\Delete(
     *     path="/tratamenduak",
     *     tags={"Tratamenduak"},
     *     description="Adierazitako ID-a erabilita datubasean tratamenduen ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Ezabatzeko tratamenduaren ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Tratamenduak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago tratamendurik ID horrekin.")
     * )
     */
    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Tratamenduak::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Tratamenduak::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
