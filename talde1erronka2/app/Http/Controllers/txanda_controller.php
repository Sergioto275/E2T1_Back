<?php

namespace App\Http\Controllers;

use App\Models\Txanda;

use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Txandak",
 *     description="Txandak kudeatzeko kontroladorea"
 * )
 */
class txanda_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/txanda",
     *     tags={"Txandak"},
     *     description="Txanda guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Txanda guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du txandarik topatu.")
     * )
     */
    public function getAll()
    {
        $belajar = Txanda::all();
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados",], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }
    /**
     * @OA\Get(
     *     path="/txanda/{id}",
     *     tags={"Txandak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Txandaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera txanda bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako txanda bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du txandarik topatu ID horrekin.")
     * )
     */
    public function getById($id)
    {
        $belajar = Txanda::find($id);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }
    /**
     * @OA\Post(
     *     path="/txanda",
     *     tags={"Txandak"},
     *     description="Adierazitako informazioarekin txanda berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id_langilea", type="integer", description="Txandaren langilearen ID-a"),
     *         @OA\Property(property="kodea", type="string", description="Txandaren kodea"),
     *         @OA\Property(property="mota", type="string", description="Txandaren mota"),
     *         @OA\Property(property="data", type="string", format="date-time", description="Txandaren data eta ordua"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Txandaren sortze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="201", description="Txanda ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request)
    {
        $datos = $request->all();

        // Convierte la fecha actual a un formato que solo incluya la fecha
        $fechaActual = now()->format('Y-m-d');

        // Formatea la fecha del JSON al formato 'Y-m-d' para la comparación
        $fechaData = date('Y-m-d', strtotime($datos['data']));

        // Verifica si ya existe un registro con la misma mota, fecha y grupo
        $registroExistente = Txanda::where([
            'mota' => $datos['mota'],
            'data' => $fechaData,
        ])
            ->whereDate('sortze_data', $fechaActual) // Comparación solo con la fecha
            ->first();

        // Si ya existe, devuelve una respuesta indicando que ya existe
        if ($registroExistente) {
            return response('Ya existe un registro con la misma mota, fecha y grupo.', 409);
        }

        // Si no existe, realiza la inserción
        $data = [
            "mota" => $datos["mota"],
            "data" => $fechaData,  // Utiliza la fecha formateada
            "id_langilea" => $datos["id_langilea"],
            "sortze_data" => $datos["sortze_data"]
        ];

        Txanda::insert($data);

        return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/txanda",
     *     tags={"Txandak"},
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Txandaren ID-a"),
     *         @OA\Property(property="id_langilea", type="integer", description="Txandaren langilearen ID-a"),
     *         @OA\Property(property="kodea", type="string", description="Txandaren kodea"),
     *         @OA\Property(property="mota", type="string", description="Txandaren mota"),
     *         @OA\Property(property="data", type="string", format="date-time", description="Txandaren data eta ordua"),
     *         @OA\Property(property="sortze_data", type="string", format="date-time", description="Txandaren sortze-data eta ordua"),
     *     )
     * ),
     *     description="Adierazitako informazioaren arabera txanda bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Txanda ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du txandarik topatu ID horrekin.")
     * )
     */
    public function update(Request $request)
    {
        $datos = $request->all();
        $belajar = Txanda::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            Txanda::where('id', $datos['id'])->update(array("mota" => $datos["mota"], "id_langilea" => $datos["id_langilea"], "eguneratze_data" => $datos["eguneratze_data"]));
            return response('', 202);
        }

    }
    /**
     * @OA\Delete(
     *     path="/txanda",
     *     tags={"Txandak"},
     *     description="Adierazitako ID-a erabilita datubasean txandaren ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="Elementuaren ID-a"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Txandak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago txandarik ID horrekin.")
     * )
     */
    public function delete(Request $request)
    {
        $datos = $request->all();
        $belajar = Txanda::find($datos['id']);
        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            Txanda::where('id', $datos['id'])->update(array('ezabatze_data' => $datos['ezabatze_data']));
            return response('', 200);
        }
    }
}
