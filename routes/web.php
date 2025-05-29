<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

require __DIR__.'/scheduling.php';
require __DIR__.'/services.php';
require __DIR__.'/auth.php';
require __DIR__.'/agenda.php';