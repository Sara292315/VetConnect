<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación del formulario de solicitud de citas.
 *
 * Cada regla se homologa con las validaciones HTML5 del frontend:
 * required, email, tel, number, date, min, max, etc.
 */
class CitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Primera versión sin autenticación: se permite el registro público.
        return true;
    }

    public function rules(): array
    {
        return [
            'propietario_id'  => ['required', 'integer', 'exists:usuarios,id'],
            'mascota_id'      => ['required', 'integer', 'exists:mascotas,id'],
            'servicio_id'     => ['nullable', 'integer', 'exists:servicios,id'],
            'fecha'           => ['required', 'date', 'after_or_equal:today'],
            'hora'            => ['required', 'date_format:H:i'],
            'motivo'          => ['required', 'string', 'max:255'],
            'observaciones'   => ['nullable', 'string', 'max:1000'],
            'estado'          => ['sometimes', 'in:pendiente,confirmada,completada,cancelada'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required'          => 'La fecha de la cita es obligatoria.',
            'fecha.after_or_equal'    => 'La fecha no puede ser anterior a hoy.',
            'hora.required'           => 'La hora de la cita es obligatoria.',
            'motivo.required'         => 'Debe indicar el motivo de la consulta.',
            'mascota_id.exists'       => 'La mascota seleccionada no existe.',
            'propietario_id.exists'   => 'El propietario seleccionado no existe.',
        ];
    }
}