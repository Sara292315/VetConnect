<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Mascota;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Servicio de Citas.
 *
 * CAPA 2: LÓGICA DE NEGOCIO.
 * Aquí se aplican las reglas de negocio de la plataforma:
 *   - La fecha no puede ser anterior a hoy.
 *   - No pueden existir dos citas para la misma mascota a la misma hora.
 *   - La mascota debe pertenecer al propietario que solicita la cita.
 *   - El estado de la cita debe ser uno de los estados permitidos.
 */
class CitaService
{
    /**
     * Agenda una nueva cita validando las reglas de negocio.
     *
     * @param array $datos Datos validados por CitaRequest
     * @return Cita
     */
    public function agendar(array $datos): Cita
    {
        return DB::transaction(function () use ($datos) {
            $this->validarFechaFutura($datos['fecha']);
            $this->validarHorarioLaboral($datos['hora']);

            // La hora llega como "HH:MM"; se guarda completa en MySQL.
            $datos['hora'] = $datos['hora'] . ':00';

            $mascota = Mascota::findOrFail($datos['mascota_id']);

            // Regla: la mascota debe pertenecer al propietario que agenda.
            if ($mascota->propietario_id != $datos['propietario_id']) {
                throw ValidationException::withMessages([
                    'mascota_id' => 'La mascota seleccionada no pertenece al propietario indicado.',
                ]);
            }

            // Regla: no repetir cita para la misma mascota, misma fecha y hora.
            $existente = Cita::where('mascota_id', $datos['mascota_id'])
                ->where('fecha', $datos['fecha'])
                ->where('hora', $datos['hora'])
                ->whereIn('estado', ['pendiente', 'confirmada'])
                ->exists();

            if ($existente) {
                throw ValidationException::withMessages([
                    'mascota_id' => 'La mascota ya tiene una cita en esa fecha y hora.',
                ]);
            }

            $datos['estado'] = $datos['estado'] ?? 'pendiente';

            return Cita::create($datos);
        });
    }

    /**
     * Actualiza el estado de una cita (regla de negocio).
     */
    public function actualizarEstado(Cita $cita, string $nuevoEstado): Cita
    {
        if (!in_array($nuevoEstado, Cita::ESTADOS, true)) {
            throw ValidationException::withMessages([
                'estado' => 'Estado no permitido. Use: ' . implode(', ', Cita::ESTADOS),
            ]);
        }

        $cita->estado = $nuevoEstado;
        $cita->save();

        return $cita;
    }

    /**
     * Lista las citas de un propietario (con sus relaciones).
     */
    public function citasDelPropietario(int $propietarioId)
    {
        return Cita::with(['mascota', 'servicio', 'veterinario'])
            ->where('propietario_id', $propietarioId)
            ->orderByDesc('fecha')
            ->get();
    }

    /**
     * Regla: la cita no puede programarse en el pasado.
     */
    private function validarFechaFutura(string $fecha): void
    {
        if (Carbon::parse($fecha)->lt(Carbon::today())) {
            throw ValidationException::withMessages([
                'fecha' => 'La fecha de la cita no puede ser anterior a hoy.',
            ]);
        }
    }

    /**
     * Regla: solo se agendan citas en el horario laboral (Lun-Sáb 09:00 - 18:00).
     */
    private function validarHorarioLaboral(string $hora): void
    {
        $h = (int) substr($hora, 0, 2);

        if ($h < 9 || $h >= 18) {
            throw ValidationException::withMessages([
                'hora' => 'El horario de atención es de 09:00 a 18:00 hrs.',
            ]);
        }
    }
}