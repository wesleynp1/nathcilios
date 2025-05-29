<?php

use App\Http\Controllers\schedulingController;
use Illuminate\Support\Facades\Route;

//CREATE
Route::get('novaMarcacao/{serviceIntentedId?}', [schedulingController::class, "formCreateScheduling"])->middleware("auth");
Route::post('novaMarcacao',             [schedulingController::class, "createScheduling"])->middleware("auth");

//READ
Route::get('agendamentos', [schedulingController::class, "readScheduling"])->middleware("auth");

//UPDATE
Route::get ('editarAgendamento/{id}', [schedulingController::class, "formUpdateScheduling"])->middleware("auth");
Route::post('editarAgendamento/{id}', [schedulingController::class, "updateScheduling"])->middleware("auth");

//DELETE
Route::get ('deletarAgendamento/{id}', [schedulingController::class, "formDeleteScheduling"])->middleware("auth");
Route::post('deletarAgendamento/{id}', [schedulingController::class, "deleteScheduling"])->middleware("auth");