<?php

use App\Models\Langile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Fruitcake\Cors\CorsMiddleware;

// ...

// Aplicar CORS a todas las rutas de la API

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//=========================================================================>
//== LANGILEAK ============================================================>
//=========================================================================>

Route::get("/langileak","App\Http\Controllers\langile_controller@getAll");
Route::get("/langileak/count/{fecha}","App\Http\Controllers\langile_controller@langile_count");
Route::get("/langileak/{id}", "App\Http\Controllers\langile_controller@getById");
Route::post("/langileak","App\Http\Controllers\langile_controller@insert");
Route::put("/langileak","App\Http\Controllers\langile_controller@update");
Route::delete("/langileak","App\Http\Controllers\langile_controller@delete");

//=========================================================================>
//== ORDUTEGIAK ===========================================================>
//=========================================================================>

Route::get("/ordutegiak","App\Http\Controllers\ordutegia_controller@getAll");
Route::get("/ordutegiak/{id}", "App\Http\Controllers\ordutegia_controller@getById");
Route::post("/ordutegiak","App\Http\Controllers\ordutegia_controller@insert");
Route::put("/ordutegiak","App\Http\Controllers\ordutegia_controller@update");
Route::delete("/ordutegiak","App\Http\Controllers\ordutegia_controller@delete");

//=========================================================================>
//== TALDEAK ==============================================================>
//=========================================================================>

Route::get("/taldeak","App\Http\Controllers\\talde_controller@getAll");
Route::get("/taldeak/{kodea}","App\Http\Controllers\\talde_controller@getById");
Route::post("/taldeak","App\Http\Controllers\\talde_controller@insert");
Route::put("/taldeak","App\Http\Controllers\\talde_controller@update");
Route::delete("/taldeak","App\Http\Controllers\\talde_controller@delete");

//=========================================================================>
//== PRODUKTUAK ===========================================================>
//=========================================================================>

Route::get("/produktuak","App\Http\Controllers\\produktua_controller@getAll");
Route::get("/produktuak/{id}","App\Http\Controllers\\produktua_controller@getById");
Route::post("/produktuak","App\Http\Controllers\\produktua_controller@insert");
Route::put("/produktuak","App\Http\Controllers\\produktua_controller@update");
Route::put("/produktuak/atera","App\Http\Controllers\\produktua_controller@actualizarStock");
Route::delete("/produktuak","App\Http\Controllers\\produktua_controller@delete");

//=========================================================================>
//== MATERIALA ============================================================>
//=========================================================================>

Route::get("/materiala","App\Http\Controllers\\materiala_controller@getAll");
Route::get("/materiala/{id}","App\Http\Controllers\\materiala_controller@getById");
Route::get("/materialalibre","App\Http\Controllers\\materiala_controller@getLibre");
Route::post("/materiala","App\Http\Controllers\\materiala_controller@insert");
Route::put("/materiala","App\Http\Controllers\\materiala_controller@update");
Route::put("/materiala/atera","App\Http\Controllers\\materiala_controller@atera");
Route::put("/materiala/bueltatu","App\Http\Controllers\\materiala_controller@bueltatu");
Route::delete("/materiala","App\Http\Controllers\\materiala_controller@delete");

//=========================================================================>
//== HITZORDUAK ===========================================================>
//=========================================================================>

Route::get("/hitzorduak","App\Http\Controllers\\hitzordu_controller@erakutsi");
Route::get("/hitzorduak/{data}","App\Http\Controllers\\hitzordu_controller@citasbydate");
Route::get("/hitzorduHome","App\Http\Controllers\\hitzordu_controller@home_hitzordu");
Route::post("/hitzorduak","App\Http\Controllers\\hitzordu_controller@insert");
Route::put("/hitzorduesleitu","App\Http\Controllers\\hitzordu_controller@asignar");
Route::put("/hitzorduaamaitu","App\Http\Controllers\\hitzordu_controller@finalizar");
Route::put("/hitzorduak","App\Http\Controllers\\hitzordu_controller@update");
Route::delete("/hitzorduak","App\Http\Controllers\\hitzordu_controller@delete");


//=========================================================================>
//== KATEGORIAK ===========================================================>
//=========================================================================>
Route::get("/kategoriak","App\Http\Controllers\\kategoria_controller@getAll");
Route::get("/kategoriak/{id}","App\Http\Controllers\\kategoria_controller@getById");
Route::post("/kategoriak","App\Http\Controllers\\kategoria_controller@insert");
Route::put("/kategoriak","App\Http\Controllers\\kategoria_controller@update");
Route::delete("/kategoriak","App\Http\Controllers\\kategoria_controller@delete");

//=========================================================================>
//== TXANDAK ==============================================================>
//=========================================================================>
Route::get("/txanda","App\Http\Controllers\\txanda_controller@getAll");
Route::get("/txanda/{id}","App\Http\Controllers\\txanda_controller@getById");
Route::post("/txanda","App\Http\Controllers\\txanda_controller@insert");
Route::put("/txanda","App\Http\Controllers\\txanda_controller@update");
Route::delete("/txanda","App\Http\Controllers\\txanda_controller@delete");

//=========================================================================>
//== BEZEROAK =============================================================>
//=========================================================================>
Route::get("/bezero","App\Http\Controllers\\bezero_controller@getAll");
Route::get("/bezero/{id}","App\Http\Controllers\\bezero_controller@getById");
Route::post("/bezero","App\Http\Controllers\\bezero_controller@insert");
Route::put("/bezero","App\Http\Controllers\\bezero_controller@update");
Route::delete("/bezero","App\Http\Controllers\\bezero_controller@delete");

//=========================================================================>
//== KOLORE ===============================================================>
//=========================================================================>
Route::get("/kolore","App\Http\Controllers\\kolore_histroriala_controller@getAll");
Route::get("/kolore/{id}","App\Http\Controllers\\kolore_histroriala_controller@getById");
Route::post("/kolore","App\Http\Controllers\\kolore_histroriala_controller@insert");
Route::put("/kolore","App\Http\Controllers\\kolore_histroriala_controller@update");
Route::delete("/kolore","App\Http\Controllers\\kolore_histroriala_controller@delete");

//=========================================================================>
//== TRATAMENDUAK =========================================================>
//=========================================================================>

Route::get("/tratamenduak","App\Http\Controllers\\tratamenduak_controller@erakutsi");
Route::get("/tratamenduByLangile/{group}","App\Http\Controllers\\tratamenduak_controller@tratamientos_groupby_langile");
Route::post("/tratamenduak","App\Http\Controllers\\tratamenduak_controller@insert");
Route::put("/tratamenduak","App\Http\Controllers\\tratamenduak_controller@update");
Route::delete("/tratamenduak","App\Http\Controllers\\tratamenduak_controller@delete");

//=========================================================================>
//== TICKET LERRO =========================================================>
//=========================================================================>

Route::post("/ticket_lerro","App\Http\Controllers\\ticket_lerro_controller@insert");

//=========================================================================>
//== TRATAMENDU KATEGORIAK ================================================>
//=========================================================================>

Route::get("/kategoriaTratamendu","App\Http\Controllers\\kategoriaTratamendu_controller@erakutzi");
Route::post("/kategoriaTratamendu","App\Http\Controllers\\kategoriaTratamendu_controller@insert");
Route::put("/kategoriaTratamendu","App\Http\Controllers\\kategoriaTratamendu_controller@update");
Route::delete("/kategoriaTratamendu","App\Http\Controllers\\kategoriaTratamendu_controller@delete");

//=========================================================================>
//== DEVOLVER =============================================================>
//=========================================================================>

Route::get("/devolver","App\Http\Controllers\\devolver_controller@erakutsi");
Route::get("/devolver/{id}","App\Http\Controllers\\devolver_controller@filterbyid");
Route::put("/devolver","App\Http\Controllers\\devolver_controller@eguneratu");
Route::post("/devolver","App\Http\Controllers\\devolver_controller@insertar");
