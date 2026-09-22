<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Modelo Mascota (tabla: mascotas).
 */
class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = [
        'propietario_id',
        'nombre',
        'especie',
        'raza',
        'edad_anios',
        'sexo',
        'color',
        'peso_kg',
    ];

    /**
     * Cada mascota pertenece a un propietario (usuario).
     */
    public function propietario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'propietario_id');
    }

    /**
     * Cada mascota tiene UN expediente clínico.
     */
    public function expediente(): HasOne
    {
        return $this->hasOne(Expediente::class, 'mascota_id');
    }

    /**
     * Una mascota puede tener varias citas.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'mascota_id');
    }
}