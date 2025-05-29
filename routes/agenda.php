<?php

use App\Http\Controllers\agendaController;
use Illuminate\Support\Facades\Route;

Route::get ('agenda', [agendaController::class, "agenda"]);
Route::post('agenda', [agendaController::class, "makeUnavailable"])->middleware('auth');

Route::get ('agenda/disponibilizar', [agendaController::class, "makeAvailableForm"])->middleware('auth');
Route::post('agenda/disponibilizar', [agendaController::class, "makeAvailable"])->middleware('auth');