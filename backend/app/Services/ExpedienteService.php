<?php

namespace App\Services;

use App\Models\Expediente;

/**
 * Servicio de Expedientes.
 *
 * CAPA 2: LÓGICA DE NEGOCIO.
 * Centraliza la lectura de expedientes y su historial de consultas.
 */
class ExpedienteService
{
    /**
     * Obtiene el expediente completo de una mascota,
     * incluyendo los datos del paciente y el historial de consultas.
     */
    public function obtenerPorMascota(int $mascotaId): ?Expediente
    {
        return Expediente::with([
            'mascota.propietario',
            'historialConsultas.veterinario',
        ])->where('mascota_id', $mascotaId)->first();
    }
}