<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Cita (tabla: citas).
 */
class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'propietario_id',
        'mascota_id',
        'veterinario_id',
        'servicio_id',
        'fecha',
        'hora',
        'motivo',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
    ];

    /**
     * Reglas de estado permitidas (regla de negocio de la capa de servicio).
     */
    public const ESTADOS = ['pendiente', 'confirmada', 'completada', 'cancelada'];

    public function propietario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'propietario_id');
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(Veterinario::class, 'veterinario_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}