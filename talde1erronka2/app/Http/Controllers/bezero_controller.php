<?php

namespace App\Http\Controllers;

use App\Models\Bezero;

use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Bezeroak",
 *     description="Bezeroak kudeatzeko kontroladorea"
 * )
 */
class bezero_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/bezeroak",
     *     tags={"Bezeroak"},
     *     description="Bezero guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Bezero guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du bezerorik topatu.")
     * )
     */
    public function getAll()
    {
        $belajar = Bezero::all();
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/bezeroak/{id}",
     *     tags={"Bezeroak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Bezeroaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera bezero bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako bezeroa bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du bezerorik topatu ID horrekin.")
     * )
     */
    public function getById($id)
    {
        $belajar = Bezero::find($id);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }
    /**
     * @OA\Post(
     *     path="/bezeroak",
     *     tags={"Bezeroak"},
     *     description="Adierazitako informazioarekin bezero berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="izena", type="string", description="Bezeroaren izena"),
     *         @OA\Property(property="abizena", type="string", description="Bezeroaren abizena"),
     *         @OA\Property(property="telefonoa", type="string", description="Bezeroaren telefono zenbakia"),
     *         @OA\Property(property="piel", type="string", description="Bezeroaren piel (Adibidez, 'E' edo 'H')"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Bezeroa ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request)
    {
        $datos=$request->all();
        date_default_timezone_set('Europe/Madrid');
            $sortze_data = date("Y-m-d H:i:s");
            $data=["izena"=>$datos["izena"],"abizena"=>$datos["abizena"],"telefonoa"=>$datos["telefonoa"],"azal_sentikorra"=>$datos["azal_sentikorra"],"sortze_data"=>$sortze_data];
            Bezero::insert($data);
            return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/bezeroak",
     *     tags={"Bezeroak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Produktuaren ID-a"),
     *         @OA\Property(property="izena", type="string", description="Produktuaren izena"),
     *         @OA\Property(property="deskribapena", type="string", description="Produktuaren deskribapena"),
     *         @OA\Property(property="id_kategoria", type="integer", description="Produktuaren kategoriaren ID-a"),
     *         @OA\Property(property="marka", type="string", description="Produktuaren marka"),
     *         @OA\Property(property="stock", type="integer", description="Produktuaren stock kantitatea"),
     *         @OA\Property(property="stock_alerta", type="integer", description="Alerta aktibatzen duen stock-aren gutxitze-maila"),
     *         @OA\Property(property="eguneratze_data", type="string", format="date-time", description="Produktuaren eguneratze-data eta ordua"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera bezero bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Bezeroa ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du bezerorik topatu ID horrekin.")
     * )
     */
    public function update(Request $request)
    {
        $datos = $request->all();
        $belajar = Bezero::find($datos['id']);
        date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            Bezero::where('id', $datos['id'])->update(array("izena" => $datos["izena"], "abizena" => $datos["abizena"],"telefonoa" => $datos["telefonoa"], "eguneratze_data" => $eguneratze_data));
            return response('', 202);
        }

    }
    /**
     * @OA\Delete(
     *     path="/bezeroak",
     *     tags={"Bezeroak"},
     *     description="Adierazitako ID-a erabilita datubasean bezeroaren ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="Elementuaren ID-a"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Produktuak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago produkturik ID horrekin.")
     * )
     */
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
