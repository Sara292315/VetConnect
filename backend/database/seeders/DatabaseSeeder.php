<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Poblador inicial de la base de datos de VetConnect.
 * Crea datos de ejemplo para que el frontend tenga información que mostrar.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Usuarios propietarios ----
        $usuarios = [
            ['id' => 1, 'nombre_completo' => 'María González',    'correo' => 'maria.gonzalez@example.com',  'telefono' => '555-0101', 'tipo_usuario' => 'propietario'],
            ['id' => 2, 'nombre_completo' => 'Carlos Ramírez',    'correo' => 'carlos.ramirez@example.com',  'telefono' => '555-0102', 'tipo_usuario' => 'propietario'],
            ['id' => 3, 'nombre_completo' => 'Laura Mendoza',     'correo' => 'laura.mendoza@example.com',   'telefono' => '555-0103', 'tipo_usuario' => 'administrativo'],
        ];
        DB::table('usuarios')->insert($usuarios);

        // ---- Veterinarios ----
        DB::table('veterinarios')->insert([
            ['id' => 1, 'usuario_id' => null, 'nombre_completo' => 'Dr. Andrés Peña',   'especialidad' => 'Medicina general / Cirugía menor', 'telefono' => '555-0201', 'correo' => 'andres.pena@vetconnect.com',  'cedula_profesional' => 'VET-0001'],
            ['id' => 2, 'usuario_id' => null, 'nombre_completo' => 'Dra. Sofía Torres', 'especialidad' => 'Medicina interna',                'telefono' => '555-0202', 'correo' => 'sofia.torres@vetconnect.com', 'cedula_profesional' => 'VET-0002'],
            ['id' => 3, 'usuario_id' => null, 'nombre_completo' => 'Dr. Luis Herrera',  'especialidad' => 'Atención preventiva / Vacunación','telefono' => '555-0203', 'correo' => 'luis.herrera@vetconnect.com','cedula_profesional' => 'VET-0003'],
        ]);

        // ---- Mascotas ----
        DB::table('mascotas')->insert([
            ['id' => 1, 'propietario_id' => 1, 'nombre' => 'Rex',   'especie' => 'perro', 'raza' => 'Labrador Retriever', 'edad_anios' => 4,   'sexo' => 'macho',  'color' => 'Dorado',       'peso_kg' => 32.50],
            ['id' => 2, 'propietario_id' => 1, 'nombre' => 'Misha', 'especie' => 'gato',  'raza' => 'Siamés',             'edad_anios' => 3,   'sexo' => 'hembra', 'color' => 'Crema / Café', 'peso_kg' => 4.20],
            ['id' => 3, 'propietario_id' => 2, 'nombre' => 'Luna',  'especie' => 'perro', 'raza' => 'Mestizo',            'edad_anios' => 2,   'sexo' => 'hembra', 'color' => 'Negro y blanco','peso_kg' => 12.80],
        ]);

        // ---- Servicios ----
        DB::table('servicios')->insert([
            ['id' => 1, 'nombre' => 'Consulta general',    'descripcion' => 'Revisión completa del estado de salud de la mascota.', 'duracion_min' => 30, 'precio_base' => 250.00, 'activo' => true],
            ['id' => 2, 'nombre' => 'Vacunación',          'descripcion' => 'Aplicación de vacunas requeridas según especie y edad.', 'duracion_min' => 20, 'precio_base' => 150.00, 'activo' => true],
            ['id' => 3, 'nombre' => 'Desparasitación',    'descripcion' => 'Control de parásitos internos y externos.', 'duracion_min' => 20, 'precio_base' => 180.00, 'activo' => true],
            ['id' => 4, 'nombre' => 'Consulta preventiva','descripcion' => 'Chequeo preventivo y asesoría de cuidados.', 'duracion_min' => 30, 'precio_base' => 220.00, 'activo' => true],
            ['id' => 5, 'nombre' => 'Control veterinario','descripcion' => 'Seguimiento de tratamientos y evolución.', 'duracion_min' => 20, 'precio_base' => 200.00, 'activo' => true],
            ['id' => 6, 'nombre' => 'Atención básica',    'descripcion' => 'Corte de uñas, limpieza de oídos y cuidados básicos.', 'duracion_min' => 25, 'precio_base' => 120.00, 'activo' => true],
        ]);

        // ---- Citas ----
        DB::table('citas')->insert([
            ['id' => 1, 'propietario_id' => 1, 'mascota_id' => 1, 'veterinario_id' => 1, 'servicio_id' => 1, 'fecha' => '2026-09-25', 'hora' => '10:00:00', 'motivo' => 'Chequeo general y tos persistente', 'observaciones' => 'Rex ha presentado tos por las mañanas.', 'estado' => 'confirmada'],
            ['id' => 2, 'propietario_id' => 1, 'mascota_id' => 2, 'veterinario_id' => 2, 'servicio_id' => 2, 'fecha' => '2026-09-28', 'hora' => '12:30:00', 'motivo' => 'Refuerzo de vacuna', 'observaciones' => 'Misha requiere dosis anual.', 'estado' => 'pendiente'],
            ['id' => 3, 'propietario_id' => 2, 'mascota_id' => 3, 'veterinario_id' => 3, 'servicio_id' => 4, 'fecha' => '2026-10-02', 'hora' => '09:30:00', 'motivo' => 'Consulta preventiva', 'observaciones' => null, 'estado' => 'pendiente'],
        ]);

        // ---- Expedientes ----
        DB::table('expedientes')->insert([
            ['id' => 1, 'mascota_id' => 1, 'ultima_consulta' => '2026-08-15', 'diagnostico_actual' => 'Infección leve de oído, en tratamiento.', 'vacunas' => 'Rabia, Moquillo, Parvovirus, Leptospira', 'proxima_vacuna' => 'Refuerzo anual Rabia: 2026-11-15', 'proxima_cita' => '2026-09-25 10:00:00', 'alergias' => 'Polvo ambiental leve'],
            ['id' => 2, 'mascota_id' => 2, 'ultima_consulta' => '2026-07-02', 'diagnostico_actual' => 'Sin padecimientos actuales.', 'vacunas' => 'Rabia, Triple Felina (TCF)', 'proxima_vacuna' => 'Triple Felina: 2026-09-28', 'proxima_cita' => '2026-09-28 12:30:00', 'alergias' => null],
            ['id' => 3, 'mascota_id' => 3, 'ultima_consulta' => '2026-08-20', 'diagnostico_actual' => 'Obesidad leve; iniciar dieta controlada.', 'vacunas' => 'Rabia, Moquillo, Parvovirus', 'proxima_vacuna' => 'Refuerzo anual Rabia: 2027-01-20', 'proxima_cita' => null, 'alergias' => null],
        ]);

        // ---- Historial de consultas ----
        DB::table('historial_consultas')->insert([
            ['id' => 1, 'expediente_id' => 1, 'mascota_id' => 1, 'veterinario_id' => 1, 'fecha' => '2026-08-15 10:00:00', 'motivo' => 'Revisión anual', 'diagnostico' => 'Oído derecho con inflamación leve.', 'tratamiento' => 'Limpieza y gotas óticas.', 'receta' => 'Gotas óticas c/12h por 7 días.', 'notas' => 'Se recomienda revalorar en 2 semanas.'],
            ['id' => 2, 'expediente_id' => 2, 'mascota_id' => 2, 'veterinario_id' => 2, 'fecha' => '2026-07-02 11:00:00', 'motivo' => 'Chequeo de rutina', 'diagnostico' => 'Paciente sano.', 'tratamiento' => 'Ninguno.', 'receta' => 'Ninguna.', 'notas' => 'Ánimo y apetito normales.'],
            ['id' => 3, 'expediente_id' => 3, 'mascota_id' => 3, 'veterinario_id' => 3, 'fecha' => '2026-08-20 09:30:00', 'motivo' => 'Consulta preventiva', 'diagnostico' => 'Peso por encima del ideal para su talla.', 'tratamiento' => 'Cambio a dieta hipocalórica.', 'receta' => 'Alimento light según porción.', 'notas' => 'Control de peso en 30 días.'],
        ]);
    }
}