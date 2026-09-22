<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla: citas.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propietario_id');
            $table->unsignedBigInteger('mascota_id');
            $table->unsignedBigInteger('veterinario_id')->nullable();
            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo', 255);
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'completada', 'cancelada'])
                ->default('pendiente');
            $table->timestamps();

            $table->foreign('propietario_id')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mascota_id')->references('id')->on('mascotas')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('veterinario_id')->references('id')->on('veterinarios')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index(['fecha', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};