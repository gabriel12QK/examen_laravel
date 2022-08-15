<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('v1/registro',[ AnimalController::class,'register']);
Route::post('v1/login',[ AnimalController::class,'login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('v1/animal-reg',[  AnimalController::class,'registerAnimal']);
    Route::post('v1/destroy/{id}',[  AnimalController::class,'destroyAnimal']);
    Route::get('v1/buscar/{id_tipo}',[  AnimalController::class,'buscaranimal']);
    Route::get('v1/showA',[  AnimalController::class,'showAnimal']);
    Route::get('v1/showT',[  AnimalController::class,'showTipo']);
    Route::get('v1/reporte',[  AnimalController::class,'reporte']);
});
