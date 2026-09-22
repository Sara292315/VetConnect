<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ServicioController;

/*
|--------------------------------------------------------------------------
| VETCONNECT - API REST (capa de lógica de negocio)
|--------------------------------------------------------------------------
| Endpoints públicos de la primera versión.
| El frontend (Angular) consume estos recursos mediante HttpClient.
|
| Ejemplo de URLs:
|   GET  /api/servicios                -> listar catálogo de servicios
|   GET  /api/mascotas/1/expediente    -> expediente de una mascota
|   POST /api/citas                    -> solicitar una cita
|
| Estructura: USUARIO -> FRONTEND (Angular) -> API (Laravel) -> MySQL
*/

Route::prefix('v1')->group(function () {

    // ---- SERVICIOS -----------------------------------------------------
    Route::get('/servicios', [ServicioController::class, 'index']);

    // ---- MASCOTAS Y EXPEDIENTES ---------------------------------------
    Route::get('/mascotas', [MascotaController::class, 'index']);
    Route::get('/mascotas/{mascota}', [MascotaController::class, 'show']);
    Route::post('/mascotas', [MascotaController::class, 'store']);
    Route::get('/mascotas/{mascota}/expediente', [ExpedienteController::class, 'show']);

    // ---- CITAS ---------------------------------------------------------
    Route::get('/citas', [CitaController::class, 'index']);
    Route::post('/citas', [CitaController::class, 'store']);
    Route::get('/citas/{cita}', [CitaController::class, 'show']);
    Route::put('/citas/{cita}', [CitaController::class, 'update']);
    Route::delete('/citas/{cita}', [CitaController::class, 'destroy']);

    // ---- PUNTO DE SALUD DE LA API (health check) -----------------------
    Route::get('/salud', function () {
        return response()->json([
            'plataforma' => 'VetConnect',
            'version' => '1.0.0',
            'estado' => 'en-linea',
        ]);
    });
});