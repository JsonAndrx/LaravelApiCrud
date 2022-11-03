<?php

use App\Http\Controllers\Api\AutoController;
use App\Http\Controllers\Api\PublicacionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas de autenticacion
Route::post('register', [AutoController::class, 'register']);
Route::post('login', [AutoController::class, 'login']);
Route::get('users', [AutoController::class, 'allusers']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [AutoController::class, 'userProfile']);
    Route::post('logout', [AutoController::class, 'logout']);
    Route::post('publicacion/create', [PublicacionesController::class, 'create']);
    Route::put('publicacion/edit/{id}/', [PublicacionesController::class, 'edit']);
    Route::post('publicacion/delete/{id}', [PublicacionesController::class, 'delete']);
});

//Rutas de publicaciones
Route::get('index', [PublicacionesController::class, 'allpublicaciones']);
