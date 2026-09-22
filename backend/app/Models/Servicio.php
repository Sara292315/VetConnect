<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Servicio (tabla: servicios).
 */
class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_min',
        'precio_base',
        'activo',
    ];

    /**
     * Un servicio puede estar presente en muchas citas.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'servicio_id');
    }
}