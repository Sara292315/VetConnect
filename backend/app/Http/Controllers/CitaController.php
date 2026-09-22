<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaRequest;
use App\Models\Cita;
use App\Services\CitaService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de citas.
 *
 * CAPA 2 / CONTROLLER: recibe la petición HTTP, delega la regla de negocio
 * en el servicio y devuelve la respuesta JSON al frontend.
 */
class CitaController extends Controller
{
    public function __construct(private CitaService $citaService)
    {
    }

    /**
     * GET /api/v1/citas
     */
    public function index(): JsonResponse
    {
        $citas = $this->citaService->citasDelPropietario(auth()->id() ?? 1);

        return response()->json(['data' => $citas], 200);
    }

    /**
     * POST /api/v1/citas
     */
    public function store(CitaRequest $request): JsonResponse
    {
        try {
            $cita = $this->citaService->agendar($request->validated());

            return response()->json([
                'message' => 'Cita solicitada exitosamente.',
                'data'    => $cita->load(['mascota', 'servicio']),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'No fue posible agendar la cita.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * GET /api/v1/citas/{cita}
     */
    public function show(Cita $cita): JsonResponse
    {
        return response()->json(['data' => $cita->load(['mascota', 'servicio', 'veterinario'])], 200);
    }

    /**
     * PUT /api/v1/citas/{cita}
     */
    public function update(CitaRequest $request, Cita $cita): JsonResponse
    {
        $cita->update($request->validated());

        return response()->json([
            'message' => 'Cita actualizada correctamente.',
            'data'    => $cita,
        ], 200);
    }

    /**
     * DELETE /api/v1/citas/{cita}
     */
    public function destroy(Cita $cita): JsonResponse
    {
        $cita->delete();

        return response()->json(['message' => 'Cita eliminada.'], 200);
    }
}