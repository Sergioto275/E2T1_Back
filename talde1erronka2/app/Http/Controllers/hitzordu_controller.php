<?php

namespace App\Http\Controllers;

use App\Models\Hitzordu;
use App\Models\Langile;
use App\Models\Ordutegia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Tag(
 *     name="Hitzorduak",
 *     description="Hitzorduak kudeatzeko kontroladorea"
 * )
 */
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

    public function home_hitzordu(){
        $datos = Hitzordu::where(function ($query) {
            $query->whereNull('ezabatze_data')
                ->orWhere('ezabatze_data', '0000-00-00');
        })->get();

        if ($datos->isEmpty()) {
            return response()->json(["Error" => "Ez dira daturik aurkitu"], 404);
        } else {
            $citas = [];
            foreach ($datos as $dato) {
                $event = [
                    'startTime' => $dato->hasiera_ordua,
                    'endTime' => $dato->amaiera_ordua,
                    'text' => 'El cliente: ' . $dato->izena . '; Descripcion de la cita: ' . $dato->deskribapena,
                    'link' => ''
                ];
                $citas = $this->agregarEvento($citas, $dato->data, $event);
            }

            return response()->json($citas, 200);
        }
    }
    public function erakutsi()
    {
        $datos = Hitzordu::leftJoin('langilea', 'hitzordua.id_langilea', '=', 'langilea.id')
                        ->select('hitzordua.*', 'langilea.kodea','langilea.izena as l_izena')
                        ->get();

        if ($datos->isEmpty()) {
            return response()->json(["Error" => "Ez dira daturik aurkitu"], 404);
        } else {
            return response()->json($datos, 200);
        }
    }

    public function insert(Request $request){
        $datos=$request->all();
        $eserlekua = $this->hitzordu_kop($datos["data"],$datos["hasOrdua"],$datos["amaOrdua"]);
        $eserlekua++;
        $data=["eserlekua"=>$datos["eserlekua"],"data"=>$datos["data"],"hasiera_ordua"=>$datos["hasOrdua"],"amaiera_ordua"=>$datos["amaOrdua"],"izena"=>$datos["izena"],"telefonoa"=>$datos["telefonoa"],"deskribapena"=>$datos["deskribapena"],"etxekoa"=>$datos["etxekoa"]];
        Hitzordu::insert($data);
        return response('', 201);
    }

    // Funtzio honen bitartez ordu tarte batean lortzen dugu zenbat hitzordu artuta daude 
    public function hitzordu_kop($data, $hasiera_ordua, $amaiera_ordua)
    {
        $count = Hitzordu::where('data', '=', $data)
            ->where(function ($query) use ($hasiera_ordua, $amaiera_ordua) {
                $query->where(function ($innerQuery) use ($hasiera_ordua) {
                    $innerQuery->where('hasiera_ordua', '<=', $hasiera_ordua)
                        ->where('amaiera_ordua', '>=', $hasiera_ordua);
                })
                ->orWhere(function ($innerQuery) use ($amaiera_ordua) {
                    $innerQuery->where('hasiera_ordua', '<=', $amaiera_ordua)
                        ->where('amaiera_ordua', '>=', $amaiera_ordua);
                });
            })
            ->where(function ($query) {
                $query->whereNull('ezabatze_data')
                    ->orWhere('ezabatze_data', '0000-00-00');
            })
            ->count();

        return $count;
    }

    public function citasbydate($data){
        if($data){
            $fecha = $data;
        }else{
            date_default_timezone_set('Europe/Madrid');
            $fecha =date("Y-m-d");
        }
        $citas = Hitzordu::where('data','=',$fecha)->get();
        if($citas->isEmpty()){
            return response()->json(["Error" => "Ez dira daturik aurkitu"], 404);
        }else{
            return response()->json($citas, 200);
        }
    }

    public function update(Request $request){
        $datos=$request->all();
        $belajar = Hitzordu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Hitzordu::where('id', $datos['id'])->update(array('eserlekua'=>$datos['eserlekua'],'data'=>$datos['data'],'hasiera_ordua'=>$datos['hasiera_ordua'],'amaiera_ordua'=>$datos['amaiera_ordua'],'izena'=>$datos['izena'],'telefonoa'=>$datos['telefonoa'],'deskribapena'=>$datos['deskribapena'],'etxekoa'=>$datos['etxekoa'], "eguneratze_data" => $eguneratze_data));
            return response('', 202);
        }
    }

    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Hitzordu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Hitzordu::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }

    public function asignar(Request $request){
        $datos=$request->all();
        $belajar = Hitzordu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            $hasiera_ordua_erreala = date("H:i:s");
            Hitzordu::where('id', $datos['id'])->update(array('hasiera_ordua_erreala'=>$hasiera_ordua_erreala,'id_langilea'=>$datos["id_langilea"], "eguneratze_data" => $eguneratze_data));
            return response('', 200);
        }
    }

    public function finalizar(Request $request){
        $datos=$request->all();
        $belajar = Hitzordu::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            $amaiera_ordua_erreala = date("H:i:s");
            Hitzordu::where('id', $datos['id'])->update(array('prezio_totala'=>$datos['prezio_totala'],'amaiera_ordua_erreala'=>$amaiera_ordua_erreala, "eguneratze_data" => $eguneratze_data));
            return response('', 200);
        }
    }
}
