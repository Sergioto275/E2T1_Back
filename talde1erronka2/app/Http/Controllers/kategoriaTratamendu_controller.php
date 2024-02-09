<?php

namespace App\Http\Controllers;

use App\Models\KategoriaTratamendu;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Tratamenduen kategoriak",
 *     description="Tratamenduen kategoriak kudeatzeko kontroladorea"
 * )
 */
class kategoriaTratamendu_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/kategoriaTratamendu",
     *     tags={"Tratamenduen kategoriak"},
     *     description="Tratamenduen kategoria guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Tratamenduen kategoriak guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du kategoriarik topatu.")
     * )
     */
    public function erakutsi()
    {
        $belajar = KategoriaTratamendu::all();
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }
    /**
     * @OA\Post(
     *     path="/kategoriaTratamendu",
     *     tags={"Tratamenduen kategoriak"},
     *     description="Adierazitako informazioarekin kategoria berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="izena", type="string", description="Kategoriaren izena"),
     *         @OA\Property(property="kolorea", type="string", description="Kategoriaren kolorea"),
     *         @OA\Property(property="extra", type="string", description="Kategoriaren extra (Adibidez, 's' edo 'n')"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Kategoria ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
        $datos = $request->all();
        $data = ["izena"=>$datos["izena"],"kolorea"=>$datos["kolorea"],"extra"=>$datos["extra"]];
        KategoriaTratamendu::insert($data);
        return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/kategoriaTratamendu",
     *     tags={"Tratamenduen kategoriak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Kategoriaren ID-a"),
     *         @OA\Property(property="izena", type="string", description="Kategoriaren izena"),
     *         @OA\Property(property="kolorea", type="string", description="Kategoriaren kolorea"),
     *         @OA\Property(property="extra", type="string", description="Kategoriaren extra (Adibidez, 's' edo 'n')"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera kategoria bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Kategoria ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du kategoriarik topatu ID horrekin.")
     * )
     */
    public function update(Request $request){
        $datos=$request->all();
        $belajar = KategoriaTratamendu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            KategoriaTratamendu::where('id', $datos['id'])->update(array('izena'=>$datos["izena"],"kolorea"=>$datos["kolorea"],"extra"=>$datos["extra"],"eguneratze_data"=>$eguneratze_data));
            return response('', 200);
        }
    }
    /**
     * @OA\Delete(
     *     path="/kategoriaTratamendu",
     *     tags={"Tratamenduen kategoriak"},
     *     description="Adierazitako ID-a erabilita datubasean kategoriaren ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="Elementuaren ID-a"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Kategoriak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago kategoriarik ID horrekin.")
     * )
     */
    public function delete(Request $request){
        $datos=$request->all();
        $belajar = KategoriaTratamendu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            KategoriaTratamendu::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
}
