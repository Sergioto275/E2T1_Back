<?php

namespace App\Http\Controllers;
use App\Models\Produktua;
use App\Models\Produktu_Mugimendua;
use App\Models\Kategoria;
use Carbon\Carbon;

use Illuminate\Http\Request;

class produktua_controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/produktuak",
     *     @OA\Response(response="200", description="Display a listing of produktuak.")
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
}
