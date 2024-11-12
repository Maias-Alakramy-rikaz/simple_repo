<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/exporter/{id}',[App\Http\Controllers\API\ExporterController::class,'show']);
Route::get('/importer/{id}',[App\Http\Controllers\API\ImporterController::class,'show']);
