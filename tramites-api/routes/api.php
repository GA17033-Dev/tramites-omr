<?php

use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\TramiteController;
use Illuminate\Support\Facades\Route;



// Instituciones
Route::get('/instituciones', [InstitucionController::class, 'index']);
Route::post('/instituciones', [InstitucionController::class, 'store']);

// Trámites
Route::get('/tramites',        [TramiteController::class, 'index']);
Route::post('/tramites',       [TramiteController::class, 'store']);
Route::get('/tramites/{tramite}',    [TramiteController::class, 'show'])->whereNumber('tramite');
Route::put('/tramites/{tramite}',    [TramiteController::class, 'update'])->whereNumber('tramite');
Route::delete('/tramites/{tramite}', [TramiteController::class, 'destroy'])->whereNumber('tramite');
