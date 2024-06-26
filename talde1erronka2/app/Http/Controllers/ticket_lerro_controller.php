<?php

namespace App\Http\Controllers;

use App\Models\Hitzordu;
use App\Models\Ticket_lerro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Tag(
 *     name="Ticket lerro",
 *     description="Ticket-en lerroak kudeatzeko kontroladorea"
 * )
 */
class ticket_lerro_controller extends Controller
{
    /**
     * @OA\Post(
     *     path="/ticket_lerro",
     *     tags={"Ticket lerro"},
     *     description="Adierazitako informazioarekin ticket lerro bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id_hitzordu", type="string", description="Hitzorduaren ID-a"),
     *         @OA\Property(
     *             property="tratamendua",
     *             type="array",
     *             description="Tratamenduak",
     *             @OA\Items(
     *                 @OA\Property(property="tratamendu_id", type="integer", description="Tratamenduaren ID-a"),
     *                 @OA\Property(property="prezioa", type="string", description="Tratamenduaren prezioa"),
     *             )
     *         ),
     *     )
     * ),
     *     @OA\Response(response="201", description="Erregistroa ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $datos = $request->all();

            foreach($datos["tratamendua"] as $tratamendu) {
                Ticket_lerro::insert([
                    "id_hitzordua" => $datos["id_hitzordu"],
                    "id_tratamendua" => $tratamendu["tratamendu_id"],
                    "prezioa" => $tratamendu["prezioa"]
                ]);
            }

            DB::commit();
            return response('', 201);
        } catch (\Exception $e) {
            // Ocurrió un error, realizamos un rollback
            DB::rollBack();
            return response("Error al insertar lineas de tratamientos", 500); // Puedes personalizar el código de estado y el mensaje de respuesta según tus necesidades.
        }
    }

    public function getAll(){
        $hitzorduak = Hitzordu::whereIn('id', function ($query) {
            $query->select('id_hitzordua')
                ->from(with(new Ticket_lerro)->getTable());
        })->get();
        foreach ($hitzorduak as $ticket) {
            $ticket["ticket"] = Ticket_lerro::select('ticket_lerroa.id', 'ticket_lerroa.prezioa', 'tratamendua.izena')
                            ->join('tratamendua', 'ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
                            ->where('ticket_lerroa.id_hitzordua', $ticket["id"])
                            ->where(function ($query) {
                                $query->where('ticket_lerroa.ezabatze_data', '0000-00-00 00:00:00')
                                    ->orWhereNull('ticket_lerroa.ezabatze_data');
                            })
                            ->get();
        }     

        if(!$hitzorduak){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response() -> json($hitzorduak, 200);
        }
    }
}
