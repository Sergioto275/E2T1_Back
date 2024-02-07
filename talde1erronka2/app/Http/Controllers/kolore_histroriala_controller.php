<?php

namespace App\Http\Controllers;

use App\Models\Kolore_historiala;

use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Koloreak",
 *     description="Kolore historiala kudeatzeko kontroladorea"
 * )
 */
class kolore_histroriala_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/kolore",
     *     tags={"Koloreak"},
     *     description="Kolore guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Kolore guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du kolorerik topatu.")
     * )
     */
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
    /**
     * @OA\Get(
     *     path="/kolore/{id}",
     *     tags={"Koloreak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Kolorearen ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera kolore bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako kolorea bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du kolorerik topatu ID horrekin.")
     * )
     */
    public function getById($id)
    {
        $belajar = Kolore_historiala::join('produktua', 'kolore_historiala.id_produktua', '=', 'produktua.id')
                            ->select('kolore_historiala.*', 'produktua.izena as produktua_izena','produktua.marka as produktua_marka')
                            ->where('kolore_historiala  .id', $id)
                            ->get();

        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }
    /**
     * @OA\Post(
     *     path="/kolore",
     *     tags={"Koloreak"},
     *     description="Adierazitako informazioarekin kolore berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="data", type="string", format="date-time", description="Transakzioaren data eta ordua"),
     *         @OA\Property(property="id_bezeroa", type="integer", description="Bezeroaren ID-a"),
     *         @OA\Property(property="id_produktua", type="integer", description="Produktuaren ID-a"),
     *         @OA\Property(property="kantitatea", type="integer", description="Produktu kantitatea"),
     *         @OA\Property(property="bolumena", type="integer", description="Produktuaren bolumena"),
     *         @OA\Property(property="oharrak", type="string", description="Oharrak edo komenlarioak"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Produktua ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request)
    {
        date_default_timezone_set('Europe/Madrid');
        $sortze_data = date("Y-m-d H:i:s");
        $datos=$request->all();
            $data=["id_bezeroa"=>$datos["id_bezeroa"],"id_produktua"=>$datos["id_produktua"],"data"=>$datos["data"],"kantitatea"=>$datos["kantitatea"],"bolumena"=>$datos["bolumena"],"oharrak"=>$datos["oharrak"],"sortze_data"=>$sortze_data];
            Kolore_historiala::insert($data);
            return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/kolore",
     *     tags={"Koloreak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Transakzioaren ID-a"),
     *         @OA\Property(property="data", type="string", format="date", description="Transakzioaren data"),
     *         @OA\Property(property="id_bezeroa", type="integer", description="Bezeroaren ID-a"),
     *         @OA\Property(property="id_produktua", type="integer", description="Produktuaren ID-a"),
     *         @OA\Property(property="kantitatea", type="integer", description="Produktu kantitatea"),
     *         @OA\Property(property="bolumena", type="string", description="Kolorearen bolumena"),
     *         @OA\Property(property="oharrak", type="string", description="Oharrak edo komentarioak"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera kolore bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Kolorea ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du kolorerik topatu ID horrekin.")
     * )
     */
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
    /**
     * @OA\Delete(
     *     path="/kolore",
     *     tags={"Koloreak"},
     *     description="Adierazitako ID-a erabilita datubasean koloreen ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="Elementuaren ID-a"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Koloreak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago kolorerik ID horrekin.")
     * )
     */
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
