<?php

use App\Http\Controllers\ControladorLangile;
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
Route::delete('/langileakdelete/{id}', [ControladorLangile::class, 'delete']);


