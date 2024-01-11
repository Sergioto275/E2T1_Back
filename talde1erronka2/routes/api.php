<?php

use App\Http\Controllers\ControladorLangile;
use App\Http\Controllers\ControladorOrdutegia;

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

Route::get("/langileak","App\Http\Controllers\ControladorLangile@erakutzi");
Route::get('/langileak/{id}', [ControladorLangile::class, 'erakutzibyid']);
Route::post("/langileak","App\Http\Controllers\ControladorLangile@insert");
Route::put("/langileak","App\Http\Controllers\ControladorLangile@update");
Route::delete("/langileak","App\Http\Controllers\ControladorLangile@delete");

Route::get("/ordutegiak","App\Http\Controllers\ControladorOrdutegia@erakutzi");
Route::post("/ordutegiak","App\Http\Controllers\ControladorOrdutegia@insert");
Route::put("/ordutegiak","App\Http\Controllers\ControladorOrdutegia@update");
Route::get('/ordutegiakortubyid/{id}', [ControladorOrdutegia::class, 'erakutzibyid']);
Route::delete("/ordutegiak","App\Http\Controllers\ControladorOrdutegia@delete");

Route::get("/taldeak","App\Http\Controllers\\talde_controller@taldeak_kargatu");
Route::get("/taldeaklortubycode/{kodea}","App\Http\Controllers\\talde_controller@taldeak_kargatu_byid");
Route::post("/taldeaksortu","App\Http\Controllers\\talde_controller@taldea_insert");
Route::put("/taldeak","App\Http\Controllers\\talde_controller@taldea_update");
Route::delete("/taldeak","App\Http\Controllers\\talde_controller@taldea_delete");



