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

Route::get("/langileaklortu","App\Http\Controllers\ControladorLangile@erakutzi");
Route::post("/langileaksortu","App\Http\Controllers\ControladorLangile@insert");
Route::put("/langileakeguneratu","App\Http\Controllers\ControladorLangile@update");
Route::get('/langileaklortubyid/{id}', [ControladorLangile::class, 'erakutzibyid']);
Route::put("/langileakdelete","App\Http\Controllers\ControladorLangile@delete");

Route::get("/ordutegiaklortu","App\Http\Controllers\ControladorOrdutegia@erakutzi");
Route::post("/ordutegiaksortu","App\Http\Controllers\ControladorOrdutegia@insert");
Route::put("/ordutegiakeguneratu","App\Http\Controllers\ControladorOrdutegia@update");
Route::get('/ordutegiakortubyid/{id}', [ControladorOrdutegia::class, 'erakutzibyid']);
Route::put("/ordutegiakdelete","App\Http\Controllers\ControladorOrdutegia@delete");
Route::get("/txandaklortu","App\Http\Controllers\\txanda_controller@txandak_kargatu");
