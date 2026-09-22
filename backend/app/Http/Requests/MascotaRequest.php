<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación del registro de una mascota.
 */
class MascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'propietario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'nombre'         => ['required', 'string', 'max:80'],
            'especie'        => ['required', 'in:perro,gato,ave,roedor,otro'],
            'raza'           => ['nullable', 'string', 'max:80'],
            'edad_anios'     => ['nullable', 'numeric', 'min:0', 'max:50'],
            'sexo'           => ['required', 'in:macho,hembra,desconocido'],
            'color'          => ['nullable', 'string', 'max:60'],
            'peso_kg'        => ['nullable', 'numeric', 'min:0.1', 'max:200'],
        ];
    }
}