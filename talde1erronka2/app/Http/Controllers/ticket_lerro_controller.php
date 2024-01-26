<?php

namespace App\Http\Controllers;

use App\Models\Ticket_lerro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ticket_lerro_controller extends Controller
{
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
}
