<?php

namespace App\Http\Controllers;

use App\Models\Materiala;
use App\Models\Materiala_Erabili;
use App\Models\Kategoria;
use Carbon\Carbon;

use Illuminate\Http\Request;

class materiala_controller extends Controller
{
    public function getAll()
    {
        $belajar = Materiala::all();

        if ($belajar->isEmpty()) {
            return response()->json(['Error' => "No hay resultados"], 404);
        } else {
            return response()->json($belajar, 200);
        }
    }

    public function getById($id)
    {
        $belajar = Materiala::find($id);

        if (!$belajar) {
            return response()->json(['Error' => "No hay resultados con ese ID",], 404);
        } else {
            return response()->json($belajar);
        }
    }

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
