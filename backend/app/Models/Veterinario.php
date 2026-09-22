<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Veterinario (tabla: veterinarios).
 */
class Veterinario extends Model
{
    use HasFactory;

    protected $table = 'veterinarios';

    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'especialidad',
        'telefono',
        'correo',
        'cedula_profesional',
    ];

    /**
     * Un veterinario puede vincularse (opcionalmente) a un usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Un veterinario atiende varias citas.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'veterinario_id');
    }
}