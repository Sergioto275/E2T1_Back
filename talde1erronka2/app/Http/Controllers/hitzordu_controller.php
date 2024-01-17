<?php

namespace App\Http\Controllers;

use App\Models\hitzordu_model;
use Illuminate\Http\Request;
use Carbon\Carbon;


class hitzordu_controller extends Controller
{

    function agregarEvento($array, $fecha, $evento) {
        $fechaCarbon = Carbon::parse($fecha);
        $ano = $fechaCarbon->year;
        $mes = $fechaCarbon->month;
        $dia = $fechaCarbon->day;
    
        // Asegurarse de que el año esté presente en el array
        if (!isset($array[$ano])) {
            $array[$ano] = [];
        }
    
        // Asegurarse de que el mes esté presente en el año
        if (!isset($array[$ano][$mes])) {
            $array[$ano][$mes] = [];
        }
    
        // Asegurarse de que el día esté presente en el mes
        if (!isset($array[$ano][$mes][$dia])) {
            $array[$ano][$mes][$dia] = [];
        }
    
        // Añadir el evento al día correspondiente
        $array[$ano][$mes][$dia][] = $evento;
    
        return $array;
    }

    public function erakutzi(){
        $datos = hitzordu_model::all();

        if (!$datos) {
            return response()->json(["Error" => "Ez dira daturik aurkitu"], 404);
        } else {
            $citas = [];
            foreach ($datos as $dato) {
                $event = [
                    'startTime' => $dato->hasiera_ordua,
                    'endTime' => $dato->amaiera_ordua,
                    'text' => 'El cliente: '.$dato->izena.'; Descripcion de la cita: '.$dato->deskribapena,
                    'link' => ''
                ];
                $citas = $this->agregarEvento($citas,$dato->data,$event);
                // $fecha = Carbon::parse($dato->sortze_data);
                // $dato->ano = $fecha->year;
                // $dato->mes = $fecha->month;
                // $dato->dia = $fecha->day;
            }
    
            return response()->json($citas, 200);
        }
    }

    
}
