<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Expediente (tabla: expedientes).
 */
class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expedientes';

    protected $fillable = [
        'mascota_id',
        'ultima_consulta',
        'diagnostico_actual',
        'vacunas',
        'proxima_vacuna',
        'proxima_cita',
        'alergias',
    ];

    protected $casts = [
        'ultima_consulta' => 'date',
        'proxima_cita'    => 'datetime',
    ];

    /**
     * Cada expediente pertenece a una mascota.
     */
    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    /**
     * Un expediente agrupa varias consultas en el historial.
     */
    public function historialConsultas(): HasMany
    {
        return $this->hasMany(HistorialConsulta::class, 'expediente_id');
    }
}