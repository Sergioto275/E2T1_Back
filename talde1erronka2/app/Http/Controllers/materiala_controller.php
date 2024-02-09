<?php

namespace App\Http\Controllers;

use App\Models\Materiala;
use App\Models\Materiala_Erabili;
use App\Models\Kategoria;
use Carbon\Carbon;

use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Materiala",
 *     description="Materiala kudeatzeko kontroladorea"
 * )
 */
class materiala_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/materiala",
     *     tags={"Materiala"},
     *     description="Material guztia bueltatzen ditu.",
     *     @OA\Response(response="200", description="Material guztia bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du materialik topatu.")
     * )
     */
    public function getAll()
    {
        $belajar = Materiala::all();

        if ($belajar->isEmpty()) {
            return response()->json(['Error' => "No hay resultados"], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/materiala/{id}",
     *     tags={"Materiala"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Materialaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera material bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako materiala bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du materialik topatu ID horrekin.")
     * )
     */
    public function getById($id)
    {
        $belajar = Materiala::find($id);

        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }
    /**
     * @OA\Get(
     *     path="/materialalibre",
     *     tags={"Materiala"},
     *     description="Libre dagoen material guztia.",
     *     @OA\Response(response="200", description="Material guztia bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du materialik topatu.")
     * )
     */
    public function getLibre()
    {
        $materialasLibres = Materiala::select('materiala.id', 'materiala.izena', 'materiala.etiketa', 'materiala.sortze_data', 'materiala.eguneratze_data', 'materiala.ezabatze_data')
            ->leftJoin('materiala_erabili', 'materiala.id', '=', 'materiala_erabili.id_materiala')
            ->whereNotIn('materiala.id', function ($query) {
                $query->select('id_materiala')
                    ->from('materiala_erabili')
                    ->whereNotNull('hasiera_data')
                    ->whereNull('amaiera_data');
            })
            ->get();

        return response()->json($materialasLibres);
    }
    /**
     * @OA\Post(
     *     path="/materiala",
     *     tags={"Materiala"},
     *     description="Adierazitako informazioarekin material berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="etiketa", type="string", description="Materialaren etiketa"),
     *         @OA\Property(property="izena", type="string", description="Materialaren izena"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Produktua ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request)
    {
        $datos = $request->all();
        $data = [
            "etiketa" => $datos["etiketa"],
            "izena" => $datos["izena"]
        ];
        Materiala::insert($data);
        return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/materiala",
     *     tags={"Materiala"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Materialaren ID-a"),
     *         @OA\Property(property="etiketa", type="string", description="Materialaren etiketa"),
     *         @OA\Property(property="izena", type="string", description="Materialaren izena"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera material bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Materiala ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du materialik topatu ID horrekin.")
     * )
     */
    public function update(Request $request)
    {
        $datos = $request->all();
        $belajar = Materiala::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Materiala::where('id', $datos['id'])->update(array("etiketa" => $datos["etiketa"], "izena" => $datos["izena"], 'eguneratze_data' => $eguneratze_data));
            return response('', 202);
        }
    }
    /**
     * @OA\Delete(
     *     path="/materiala",
     *     tags={"Materiala"},
     *     description="Adierazitako ID-a erabilita datubasean materialaren ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Ezabatzeko produktuaren ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Materiala ondo ezabatu da datubasean."),
     *     @OA\Response(response="404", description="Ez dago materialik ID horrekin.")
     * )
     */
    public function delete(Request $request)
    {
        $datos = $request->all();
        $belajar = Materiala::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Materiala::where('id', $datos['id'])->update(array('ezabatze_data' => $ezabatze_data));
            return response('', 200);
        }
    }
    /**
     * @OA\Put(
     *     path="/materiala/atera",
     *     tags={"Materiala"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Langilearen ID-a"),
     *         @OA\Property(
     *             property="materiala",
     *             type="array",
     *             description="Materialen zerrenda",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", description="Materialaren ID-a"),
     *             )
     *         )
     *     )
     * ),
     *     description="Adierazitako langilea zein material atera duen erregistratzen du.",
     *     @OA\Response(response="202", description="Erregistroa ondo txertatu da datubasean."),
     *     @OA\Response(response="404", description="Ez du erregistrorik topatu ID horrekin.")
     * )
     */
    public function atera(Request $request)
    {
        try {
            $datuak = $request->json()->all();
            $materiala = $datuak['materiala'];
            $langileId = $datuak['id'];

            if (!is_array($datuak)) {
                return response()->json(['Error' => 'El formato de entrada es incorrecto. Se esperaba un array.'], 400);
            }

            foreach ($materiala as $material) {
                $data = [
                    "id_materiala" => $material["id"],
                    "id_langilea" => $langileId,
                    "hasiera_data" => Carbon::now(),
                ];
                Materiala_Erabili::create($data);
            }
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/materiala/bueltatu",
     *     tags={"Materiala"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="materiala",
     *             type="array",
     *             description="Materialen zerrenda",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", description="Materialaren ID-a"),
     *             )
     *         )
     *     )
     * ),
     *     description="Zein material bueltatu den erregistratzen du.",
     *     @OA\Response(response="202", description="Erregistroa ondo txertatu da datubasean."),
     *     @OA\Response(response="404", description="Ez du erregistrorik topatu ID horrekin.")
     * )
     */
    public function bueltatu(Request $request)
    {
        $materialak = $request->json()->all();

        if (!is_array($materialak)) {
            return response()->json(['Error' => 'El formato de entrada es incorrecto. Se esperaba un array.'], 400);
        }

        // Materiala_Erabili taula agertzen ez diren erregistroak gordetzeko
        $materialErabiliEz = [];

        foreach ($materialak as $material) {
            $materialErabiliActu = Materiala_Erabili::find($material["id"]);

            if (!$materialErabiliActu) {
                $materialErabiliEz[] = $material["id"];
                continue;
            }


            $materialErabiliActu->update([
                'amaiera_data' => Carbon::now(),
            ]);
        }
    }
}
