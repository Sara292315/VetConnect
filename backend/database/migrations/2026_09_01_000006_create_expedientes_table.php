<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla: expedientes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mascota_id')->unique();
            $table->date('ultima_consulta')->nullable();
            $table->text('diagnostico_actual')->nullable();
            $table->text('vacunas')->nullable();
            $table->string('proxima_vacuna', 120)->nullable();
            $table->dateTime('proxima_cita')->nullable();
            $table->text('alergias')->nullable();
            $table->timestamps();

            $table->foreign('mascota_id')->references('id')->on('mascotas')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};