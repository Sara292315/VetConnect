<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Clase base de los controladores de la API.
 * En versiones futuras puede alojar respuestas estandarizadas.
 */
abstract class Controller
{
    /**
     * Respuesta JSON estándar para errores de validación.
     */
    protected function errorJson(string $mensaje, array $errores = [], int $codigo = 422): JsonResponse
    {
        return response()->json([
            'message' => $mensaje,
            'errors'  => $errores,
        ], $codigo);
    }
}