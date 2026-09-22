<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de servicios (catálogo público).
 */
class ServicioController extends Controller
{
    /**
     * GET /api/v1/servicios
     */
    public function index(): JsonResponse
    {
        $servicios = Servicio::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        return response()->json(['data' => $servicios], 200);
    }
}