<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Services\ExpedienteService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de expedientes.
 */
class ExpedienteController extends Controller
{
    public function __construct(private ExpedienteService $expedienteService)
    {
    }

    /**
     * GET /api/v1/mascotas/{mascota}/expediente
     */
    public function show(int $mascotaId): JsonResponse
    {
        $expediente = $this->expedienteService->obtenerPorMascota($mascotaId);

        if (!$expediente) {
            return response()->json([
                'message' => 'No existe un expediente para esa mascota.',
            ], 404);
        }

        return response()->json(['data' => $expediente], 200);
    }
}