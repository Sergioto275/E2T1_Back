<?php

namespace App\Http\Controllers;
use App\Models\Produktua;
use App\Models\Produktu_Mugimendua;
use App\Models\Kategoria;
use Carbon\Carbon;

use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Produktuak",
 *     description="Produktuak kudeatzeko kontroladorea"
 * )
 */
class produktua_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/produktuak",
     *     tags={"Produktuak"},
     *     description="Produktu guztiak bueltatzen ditu.",
     *     @OA\Response(response="200", description="Produktu guztiak bueltatu ditu."),
     *     @OA\Response(response="404", description="Ez du produkturik topatu.")
     * )
     */
    public function getAll(){
        $belajar = Produktua::join('kategoria', 'produktua.id_kategoria', '=', 'kategoria.id')
                            ->select('produktua.*', 'kategoria.izena as kategoria_izena')
                            ->get();
    
        if($belajar->isEmpty()){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response()->json($belajar, 200);
        }
    }    
    /**
     * @OA\Get(
     *     path="/produktuak/{id}",
     *     tags={"Produktuak"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Produktuaren ID-a",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     description="Adierazitako ID-aren arabera produktu bat bueltatzen du.",
     *     @OA\Response(response="200", description="Aukeratutako produktua bueltatzen du."),
     *     @OA\Response(response="404", description="Ez du produkturik topatu ID horrekin.")
     * )
     */
    public function getById($id){
        $belajar = Produktua::join('kategoria', 'produktua.id_kategoria', '=', 'kategoria.id')
                            ->select('produktua.*', 'kategoria.izena as kategoria_izena')
                            ->where('produktua.id', $id)
                            ->get();        
        
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            return response()->json($belajar);
        }   
    }
    /**
     * @OA\Post(
     *     path="/produktuak",
     *     tags={"Produktuak"},
     *     description="Adierazitako informazioarekin produktu berri bat txertatzen du datubasean.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="izena", type="string", description="Produktuaren izena"),
     *         @OA\Property(property="deskribapena", type="string", description="Produktuaren deskribapena"),
     *         @OA\Property(property="id_kategoria", type="integer", description="Kategoriaren ID-a"),
     *         @OA\Property(property="marka", type="string", description="Produktuaren marka"),
     *         @OA\Property(property="stock", type="integer", description="Hasierako stock-a"),
     *         @OA\Property(property="stock_alerta", type="integer", description="Stock-a alertaren kantitatea")
     *     )
     * ),
     *     @OA\Response(response="201", description="Produktua ondo txertatu da datubasean.")
     * )
     */
    public function insert(Request $request){
            $datos=$request->all();
            $data=["izena"=>$datos["izena"],
                "deskribapena"=>$datos["deskribapena"],
                "id_kategoria"=>$datos["id_kategoria"],
                "marka"=>$datos["marka"],
                "stock" => $datos["stock"],
                "stock_alerta" => $datos["stock_alerta"]];
            Produktua::insert($data);
            return response('', 201);
    }
    /**
     * @OA\Put(
     *     path="/produktuak",
     *     tags={"Produktuak"},
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
     *     description="Adierazitako informazioaren arabera produktu bat eguneratzen du datubasean.",
     *     @OA\Response(response="202", description="Produktua ondo eguneratu da datubasean."),
     *     @OA\Response(response="404", description="Ez du produkturik topatu ID horrekin.")
     * )
     */
    public function update(Request $request){
        $datos=$request->all();
        $belajar = Produktua::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $eguneratze_data = date("Y-m-d H:i:s");
            Produktua::where('id', $datos['id'])->update(array("izena"=>$datos["izena"],"deskribapena"=>$datos["deskribapena"],"id_kategoria"=>$datos["id_kategoria"],"marka"=>$datos["marka"],"stock" => $datos["stock"],"stock_alerta" => $datos["stock_alerta"],'eguneratze_data'=>$eguneratze_data));
            return response('', 202);
        }
    }
    /**
     * @OA\Delete(
     *     path="/produktuak",
     *     tags={"Produktuak"},
     *     description="Adierazitako ID-a erabilita datubasean produktuen ezabatze logikoa egiten du.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Ezabatzeko produktuaren ID-a"),
     *         @OA\Property(property="ezabatze_data", type="string", format="date-time", description="Ezabatze-data eta ordua"),
     *     )
     * ),
     *     @OA\Response(response="200", description="Produktuak ondo ezabatu dira datubasean."),
     *     @OA\Response(response="404", description="Ez dago produkturik ID horrekin.")
     * )
     */
    public function delete(Request $request){
        $datos=$request->all();
        $belajar = Produktua::find($datos['id']);
        if(!$belajar){
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        }else{
            date_default_timezone_set('Europe/Madrid');
            $ezabatze_data = date("Y-m-d H:i:s");
            Produktua::where('id', $datos['id'])->update(array('ezabatze_data'=>$ezabatze_data));
            return response('', 200);
        }
    }
    /**
     * @OA\Put(
     *     path="/produktuak/atera",
     *     tags={"Produktuak"},
     *     description="Adierazitako informazioa erabilita datubasean produktuen stock-a eguneratzen da eta produktuen mugimendua erregistratzen da.",
     * @OA\RequestBody(
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer", description="Transakzioaren ID-a"),
     *         @OA\Property(
     *             property="produktuak",
     *             type="array",
     *             description="Produktu kopurua eta haien ID-ak",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", description="Produktuaren ID-a"),
     *                 @OA\Property(property="kantitate", type="integer", description="Produktu kopurua"),
     *             )
     *         ),
     *     )
     * ),
     *     @OA\Response(response="200", description="Produktuak ondo eguneratu dira."),
     *     @OA\Response(response="404", description="Zenbait produktu ez dira eguneratu eta produktu horien zerrenda."),
     *     @OA\Response(response="400", description="Adierazitako informazioaren formatua ez da zuzena.")
     * )
     */
    public function actualizarStock(Request $request){
        try {
            $data = $request->json()->all();
            $produktuak = $data['produktuak'];
            $langileId = $data['id'];
    
            // Verificar si $produktuak es un array
            if (!is_array($produktuak)) {
                return response()->json(['Error' => 'El formato de entrada es incorrecto. Se esperaba un array.'], 400);
            }
    
            // Productos no encontrados
            $produktuEz = [];
    
            foreach ($produktuak as $produktu) {
                $id = $produktu['id'];
                $kantitate = $produktu['kantitate'];
    
                $produktuActu = Produktua::find($id);
    
                if (!$produktuActu) {
                    $produktuEz[] = $id;
                    continue;  // Continuar con el siguiente producto
                }
    
                // Stock berria ateratako kantitatea kenduz
                $stockBerria = $produktuActu->stock - $kantitate;
    
                // Stock berria gutxienez 0 izango da
                $stockBerria = max(0, $stockBerria);
    
                // Update egin stock berriarekin
                $produktuActu->update(['stock' => $stockBerria]);

                // Orain
                $orain = Carbon::now();

                $data = [
                    "id_produktua" => $id,
                    "id_langilea" => $langileId,
                    "data" => $orain,
                    "kopurua" => $kantitate
                ];
            
                Produktu_Mugimendua::create($data);
            }
    
            // Erroreak kudeatzeko
            if (empty($produktuEz)) {
                return response()->json(['Mensaje' => 'Stock actualizado correctamente.'], 200);
            } else {
                return response()->json(['Error' => 'Algunos productos no encontrados', 'ProductosNoEncontrados' => $produktuEz], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function stock_alerta() {
        $data = Produktua::where(function ($query) {
            $query->whereNull('ezabatze_data')
                ->orWhere('ezabatze_data', '0000-00-00 00:00:00');
        })
        ->get();

        $filteredData = $data->filter(function ($item) {
            return $item->stock < $item->stock_alerta;
        });
        
        if($filteredData->isEmpty()){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response()->json($filteredData, 200);
        }
    }

    public function getMugimenduak()
    {
        $belajar = Produktu_Mugimendua::join('langilea', 'produktu_mugimendua.id_langilea', '=', 'langilea.id')
                ->join('produktua', 'produktu_mugimendua.id_produktua', '=', 'produktua.id')
                ->select(
                    'produktu_mugimendua.*',
                    'langilea.kodea',
                    'langilea.izena as langile_izena',
                    'langilea.abizenak',
                    'produktua.izena as produktu_izena'
                )
                ->where(function($query) {
                    $query->where('produktu_mugimendua.ezabatze_data', '0000-00-00 00:00:00')
                        ->orWhereNull('produktu_mugimendua.ezabatze_data');
                })
                ->get();
        if($belajar->isEmpty()){
            return response()->json(['Error' => "No hay resultados"], 404);
        } else{
            return response()->json($belajar, 200);
        }
    }
}
