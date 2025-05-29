<?php

use App\Http\Controllers\serviceController;
use Illuminate\Support\Facades\Route;

//CREATE
Route::view('novoServico',"service.createService")->middleware("auth")->middleware('can:isAdmin');
Route::post('createService', [serviceController::class, "createService"])->middleware("auth")->middleware('can:isAdmin');

//READ
Route::get('servicos', [serviceController::class, "readServices"]);

//UPDATE
Route::get ('editarServico/{idService}', [serviceController::class, "updateServiceForm"])->middleware("auth")->middleware('can:isAdmin');
Route::post('editarServico/{idService}', [serviceController::class, "updateService"])->middleware("auth")->middleware('can:isAdmin');

//DELETE
Route::get ('deletarServico/{idService}', [serviceController::class, "deleteServiceConfirm"])->middleware("auth")->middleware('can:isAdmin');
Route::post('deletarServico/{idService}', [serviceController::class, "deleteService"])->middleware("auth")->middleware('can:isAdmin');