<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotaRequest;
use App\Models\Mascota;
use App\Services\MascotaService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de mascotas.
 */
class MascotaController extends Controller
{
    public function __construct(private MascotaService $mascotaService)
    {
    }

    /**
     * GET /api/v1/mascotas
     */
    public function index(): JsonResponse
    {
        // En la primera versión se usa el propietario de ejemplo (id = 1).
        $mascotas = $this->mascotaService->mascotasDelPropietario(auth()->id() ?? 1);

        return response()->json(['data' => $mascotas], 200);
    }

    /**
     * GET /api/v1/mascotas/{mascota}
     */
    public function show(Mascota $mascota): JsonResponse
    {
        return response()->json(['data' => $mascota->load('expediente', 'propietario')], 200);
    }

    /**
     * POST /api/v1/mascotas
     */
    public function store(MascotaRequest $request): JsonResponse
    {
        $mascota = $this->mascotaService->registrar(
            $request->validated(),
            $request->input('propietario_id')
        );

        return response()->json([
            'message' => 'Mascota registrada y expediente creado.',
            'data'    => $mascota,
        ], 201);
    }
}