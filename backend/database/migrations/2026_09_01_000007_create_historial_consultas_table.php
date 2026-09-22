<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla: historial_consultas.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediente_id');
            $table->unsignedBigInteger('mascota_id');
            $table->unsignedBigInteger('veterinario_id')->nullable();
            $table->dateTime('fecha');
            $table->string('motivo', 255);
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('receta')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('expediente_id')->references('id')->on('expedientes')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mascota_id')->references('id')->on('mascotas')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('veterinario_id')->references('id')->on('veterinarios')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_consultas');
    }
};