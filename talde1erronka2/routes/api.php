<?php

use App\Http\Controllers\langile_controller;
use App\Http\Controllers\ordutegia_controller;

use App\Models\Langile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/langileak/{id}', [langile_controller::class, 'getById']);
Route::post("/langileak","App\Http\Controllers\langile_controller@insert");
Route::put("/langileak","App\Http\Controllers\langile_controller@update");
Route::delete("/langileak","App\Http\Controllers\langile_controller@delete");

//=========================================================================>
//== ORDUTEGIAK ===========================================================>
//=========================================================================>

Route::get("/ordutegiak","App\Http\Controllers\ordutegia_controller@getAll");
Route::get('/ordutegiak/{id}', [ordutegia_controller::class, 'getById']);
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
Route::delete("/produktuak","App\Http\Controllers\\produktua_controller@delete");
//=========================================================================>
//== HITZORDUAK ===========================================================>
//=========================================================================>

Route::get("/hitzorduak","App\Http\Controllers\\hitzordu_controller@erakutzi");
Route::get("/hitzorduakbydate/{data}","App\Http\Controllers\\hitzordu_controller@citasbydate");
Route::post("/hitzordu_eskuragarri","App\Http\Controllers\\hitzordu_controller@citas_diaponibles");
Route::post("/hitzorduak","App\Http\Controllers\\hitzordu_controller@insert");


//=========================================================================>
//== KATEGORIAK ===========================================================>
//=========================================================================>
Route::get("/kategoriak","App\Http\Controllers\\kategoria_controller@getAll");
Route::get("/kategoriak/{id}","App\Http\Controllers\\kategoria_controller@getById");
Route::post("/kategoriak","App\Http\Controllers\\kategoria_controller@insert");
Route::put("/kategoriak","App\Http\Controllers\\kategoria_controller@update");
Route::delete("/kategoriak","App\Http\Controllers\\kategoria_controller@delete");

Route::get("/txanda","App\Http\Controllers\\txanda_controller@getAll");
Route::get("/txanda/{id}","App\Http\Controllers\\txanda_controller@getById");
Route::post("/txanda","App\Http\Controllers\\txanda_controller@insert");
Route::put("/txanda","App\Http\Controllers\\txanda_controller@update");
Route::delete("/txanda","App\Http\Controllers\\txanda_controller@delete");
