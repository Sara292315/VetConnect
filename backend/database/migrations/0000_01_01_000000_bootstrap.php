<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CAMPAÑA DE TABLAS: Registro de timestamps (base).
 */
return new class extends Migration
{
    public function up(): void
    {
        // Tabla mínima para registrar el orden de las migraciones no es necesaria.
        // Las tablas reales se crean en las siguientes migraciones numeradas.
    }

    public function down(): void
    {
    }
};