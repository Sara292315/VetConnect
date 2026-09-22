<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo HistorialConsulta (tabla: historial_consultas).
 */
class HistorialConsulta extends Model
{
    use HasFactory;

    protected $table = 'historial_consultas';

    protected $fillable = [
        'expediente_id',
        'mascota_id',
        'veterinario_id',
        'fecha',
        'motivo',
        'diagnostico',
        'tratamiento',
        'receta',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function expediente(): BelongsTo
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(Veterinario::class, 'veterinario_id');
    }
}