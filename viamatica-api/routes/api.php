<?php

use Illuminate\Support\Facades\Route;
use App\Controllers\PeliculaController;
use App\Controllers\SalaCineController;

Route::prefix('peliculas')->group(function () {
    Route::get('/', [PeliculaController::class, 'index']);
    Route::get('/{id}', [PeliculaController::class, 'show']);
    Route::post('/', [PeliculaController::class, 'store']);
    Route::put('/{id}', [PeliculaController::class, 'update']);
    Route::delete('/{id}', [PeliculaController::class, 'destroy']);

    Route::get('/buscar/nombre', [PeliculaController::class, 'buscarPorNombre']);
    Route::get('/buscar/fecha-publicacion', [PeliculaController::class, 'buscarPorFechaPublicacion']);
});

Route::get('/salas/disponibilidad', [SalaCineController::class, 'disponibilidadPorNombre']);
