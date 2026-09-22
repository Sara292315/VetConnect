<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Usuario (tabla: usuarios).
 *
 * Capa de acceso a datos: cada modelo representa una tabla de la base
 * de datos y define sus relaciones con las demás entidades.
 */
class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'correo',
        'telefono',
        'tipo_usuario',
        'contrasena_hash',
    ];

    protected $hidden = ['contrasena_hash'];

    /**
     * Un propietario puede registrar varias mascotas.
     */
    public function mascotas(): HasMany
    {
        return $this->hasMany(Mascota::class, 'propietario_id');
    }

    /**
     * Un usuario (propietario) puede solicitar varias citas.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'propietario_id');
    }
}