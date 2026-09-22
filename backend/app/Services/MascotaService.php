<?php

namespace App\Services;

use App\Models\Mascota;

/**
 * Servicio de Mascotas.
 *
 * CAPA 2: LÓGICA DE NEGOCIO.
 * Aplica reglas relacionadas con el registro y búsqueda de pacientes.
 */
class MascotaService
{
    /**
     * Registra una nueva mascota y crea su expediente clínico vacío.
     *
     * @param array $datos Datos validados por MascotaRequest
     * @param int   $propietarioId Usuario propietario
     * @return Mascota
     */
    public function registrar(array $datos, int $propietarioId): Mascota
    {
        $datos['propietario_id'] = $propietarioId;

        $mascota = Mascota::create($datos);

        // Toda mascota registrada inicia con un expediente.
        $mascota->expediente()->create([
            'ultima_consulta'    => null,
            'diagnostico_actual' => 'Sin consultas registradas.',
            'vacunas'            => null,
            'proxima_vacuna'     => null,
            'proxima_cita'       => null,
            'alergias'           => null,
        ]);

        return $mascota->load('expediente');
    }

    /**
     * Lista las mascotas de un propietario.
     */
    public function mascotasDelPropietario(int $propietarioId)
    {
        return Mascota::with('expediente')
            ->where('propietario_id', $propietarioId)
            ->orderBy('nombre')
            ->get();
    }
}