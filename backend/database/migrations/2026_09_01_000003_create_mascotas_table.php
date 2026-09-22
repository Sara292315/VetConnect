<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla: mascotas.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propietario_id');
            $table->string('nombre', 80);
            $table->enum('especie', ['perro', 'gato', 'ave', 'roedor', 'otro'])->default('perro');
            $table->string('raza', 80)->nullable();
            $table->decimal('edad_anios', 4, 1)->nullable();
            $table->enum('sexo', ['macho', 'hembra', 'desconocido'])->default('desconocido');
            $table->string('color', 60)->nullable();
            $table->decimal('peso_kg', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('propietario_id')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};