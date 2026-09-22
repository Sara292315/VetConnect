-- ============================================================================
-- VETCONNECT
-- "Plataforma de Citas y Expediente para Veterinarias Locales"
-- Script de creación de la BASE DE DATOS (MySQL)
--
-- CAPA 4: BASE DE DATOS
-- Se definen las tablas: usuarios, mascotas, veterinarios, servicios,
-- citas, expedientes e historial_consultas, con sus claves primarias
-- y foráneas. Incluye datos de ejemplo para la primera versión.
--
-- Compatible con MySQL 5.7+ / MariaDB 10+ (XAMPP: phpMyAdmin / mysql CLI)
-- ============================================================================

-- Elimina la base de datos si ya existe (útil para reiniciar el demo).
DROP DATABASE IF EXISTS vetconnect;

-- Crea la base de datos con soporte de acentos (utf8mb4).
CREATE DATABASE vetconnect
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE vetconnect;

-- ============================================================================
-- TABLA: usuarios
-- Propietarios de mascotas y personal de la veterinaria.
-- ============================================================================
CREATE TABLE usuarios (
  id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_completo  VARCHAR(120) NOT NULL,
  correo           VARCHAR(150) NOT NULL UNIQUE,
  telefono         VARCHAR(20)  NULL,
  tipo_usuario     ENUM('propietario','veterinario','administrativo') NOT NULL DEFAULT 'propietario',
  contrasena_hash  VARCHAR(255) NULL,                -- reservado para inicio de sesión futuro
  creado_en        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================================
-- TABLA: veterinarios
-- Profesionales que atienden en la veterinaria.
-- ============================================================================
CREATE TABLE veterinarios (
  id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id        INT UNSIGNED NULL,               -- FK opcional hacia usuarios
  nombre_completo   VARCHAR(120) NOT NULL,
  especialidad      VARCHAR(100) NULL,
  telefono          VARCHAR(20)  NULL,
  correo            VARCHAR(150) NULL,
  cedula_profesional VARCHAR(50) NULL,
  creado_en         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_veterinarios_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================================
-- TABLA: mascotas
-- Pacientes registrados por los propietarios.
-- ============================================================================
CREATE TABLE mascotas (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  propietario_id INT UNSIGNED NOT NULL,              -- FK hacia usuarios
  nombre         VARCHAR(80) NOT NULL,
  especie        ENUM('perro','gato','ave','roedor','otro') NOT NULL DEFAULT 'perro',
  raza           VARCHAR(80)  NULL,
  edad_anios     DECIMAL(4,1) NULL,                  -- edad en años (acepta 0.5)
  sexo           ENUM('macho','hembra','desconocido') NOT NULL DEFAULT 'desconocido',
  color          VARCHAR(60)  NULL,
  peso_kg        DECIMAL(5,2) NULL,
  creado_en      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_mascotas_propietario
    FOREIGN KEY (propietario_id) REFERENCES usuarios (id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_mascotas_nombre (nombre)
) ENGINE=InnoDB;

-- ============================================================================
-- TABLA: servicios
-- Catálogo de servicios veterinarios (consulta, vacunación, etc.).
-- ============================================================================
CREATE TABLE servicios (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre         VARCHAR(100) NOT NULL UNIQUE,
  descripcion    TEXT         NULL,
  duracion_min   INT UNSIGNED NOT NULL DEFAULT 30,   -- duración estimada en minutos
  precio_base    DECIMAL(10,2) NULL,
  activo         TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ============================================================================
-- TABLA: citas
-- Solicitudes de cita realizadas por los propietarios (o el personal).
-- ============================================================================
CREATE TABLE citas (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  propietario_id INT UNSIGNED NOT NULL,              -- FK hacia usuarios
  mascota_id     INT UNSIGNED NOT NULL,              -- FK hacia mascotas
  veterinario_id INT UNSIGNED NULL,                  -- FK hacia veterinarios
  servicio_id    INT UNSIGNED NULL,                  -- FK hacia servicios
  fecha          DATE NOT NULL,
  hora           TIME NOT NULL,
  motivo         VARCHAR(255) NOT NULL,
  observaciones  TEXT NULL,
  estado         ENUM('pendiente','confirmada','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  creado_en      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_citas_propietario
    FOREIGN KEY (propietario_id) REFERENCES usuarios (id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_citas_mascota
    FOREIGN KEY (mascota_id) REFERENCES mascotas (id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_citas_veterinario
    FOREIGN KEY (veterinario_id) REFERENCES veterinarios (id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_citas_servicio
    FOREIGN KEY (servicio_id) REFERENCES servicios (id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX idx_citas_fecha (fecha, estado)
) ENGINE=InnoDB;

-- ============================================================================
-- TABLA: expedientes
-- Expediente clínico general de la mascota (1 a 1 con mascotas).
-- ============================================================================
CREATE TABLE expedientes (
  id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  mascota_id          INT UNSIGNED NOT NULL UNIQUE,  -- FK: expediente único por mascota
  ultima_consulta     DATE NULL,
  diagnostico_actual  TEXT NULL,
  vacunas             TEXT NULL,                     -- ejemplo: "Rabia (2026-01-15)"
  proxima_vacuna      VARCHAR(120) NULL,
  proxima_cita        DATETIME NULL,
  alergias            TEXT NULL,
  creado_en           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_expedientes_mascota
    FOREIGN KEY (mascota_id) REFERENCES mascotas (id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================================
-- TABLA: historial_consultas
-- Registro histórico de cada consulta atendida.
-- ============================================================================
CREATE TABLE historial_consultas (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  expediente_id   INT UNSIGNED NOT NULL,             -- FK hacia expedientes
  mascota_id      INT UNSIGNED NOT NULL,             -- FK hacia mascotas
  veterinario_id  INT UNSIGNED NULL,                 -- FK hacia veterinarios
  fecha           DATETIME NOT NULL,
  motivo          VARCHAR(255) NOT NULL,
  diagnostico     TEXT NULL,
  tratamiento     TEXT NULL,
  receta          TEXT NULL,
  notas           TEXT NULL,
  creado_en       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_historial_expediente
    FOREIGN KEY (expediente_id) REFERENCES expedientes (id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_historial_mascota
    FOREIGN KEY (mascota_id) REFERENCES mascotas (id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_historial_veterinario
    FOREIGN KEY (veterinario_id) REFERENCES veterinarios (id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX idx_historial_fecha (fecha)
) ENGINE=InnoDB;

-- ============================================================================
-- DATOS DE EJEMPLO (SEEDS)
-- ============================================================================

-- Usuarios propietarios
INSERT INTO usuarios (id, nombre_completo, correo, telefono, tipo_usuario, contrasena_hash) VALUES
(1, 'María González',     'maria.gonzalez@example.com',  '555-0101', 'propietario',  NULL),
(2, 'Carlos Ramírez',     'carlos.ramirez@example.com',  '555-0102', 'propietario',  NULL),
(3, 'Laura Mendoza',      'laura.mendoza@example.com',   '555-0103', 'administrativo', NULL);

-- Veterinarios
INSERT INTO veterinarios (id, usuario_id, nombre_completo, especialidad, telefono, correo, cedula_profesional) VALUES
(1, NULL, 'Dr. Andrés Peña',   'Medicina general / Cirugía menor', '555-0201', 'andres.pena@vetconnect.com',  'VET-0001'),
(2, NULL, 'Dra. Sofía Torres', 'Medicina interna',                '555-0202', 'sofia.torres@vetconnect.com', 'VET-0002'),
(3, NULL, 'Dr. Luis Herrera',  'Atención preventiva / Vacunación','555-0203', 'luis.herrera@vetconnect.com','VET-0003');

-- Mascotas (datos de ejemplo)
INSERT INTO mascotas (id, propietario_id, nombre, especie, raza, edad_anios, sexo, color, peso_kg) VALUES
(1, 1, 'Rex',   'perro', 'Labrador Retriever', 4, 'macho',   'Dorado',      32.50),
(2, 1, 'Misha', 'gato',  'Siamés',             3, 'hembra',  'Crema / Café', 4.20),
(3, 2, 'Luna',  'perro', 'Mestizo',            2, 'hembra',  'Negro y blanco', 12.80);

-- Servicios
INSERT INTO servicios (id, nombre, descripcion, duracion_min, precio_base, activo) VALUES
(1, 'Consulta general',       'Revisión completa del estado de salud de la mascota.', 30, 250.00, 1),
(2, 'Vacunación',             'Aplicación de vacunas requeridas según especie y edad.', 20, 150.00, 1),
(3, 'Desparasitación',        'Control de parásitos internos y externos.',             20, 180.00, 1),
(4, 'Consulta preventiva',    'Chequeo preventivo y asesoría de cuidados.',            30, 220.00, 1),
(5, 'Control veterinario',    'Seguimiento de tratamientos y evolución.',              20, 200.00, 1),
(6, 'Atención básica',        'Corte de uñas, limpieza de oídos y cuidados básicos.',   25, 120.00, 1);

-- Citas (datos de ejemplo)
INSERT INTO citas (id, propietario_id, mascota_id, veterinario_id, servicio_id, fecha, hora, motivo, observaciones, estado) VALUES
(1, 1, 1, 1, 1, '2026-09-25', '10:00:00', 'Chequeo general y tos persistente', 'Rex ha presentado tos por las mañanas.', 'confirmada'),
(2, 1, 2, 2, 2, '2026-09-28', '12:30:00', 'Refuerzo de vacuna',              'Misha requiere dosis anual.', 'pendiente'),
(3, 2, 3, 3, 4, '2026-10-02', '09:30:00', 'Consulta preventiva',             NULL, 'pendiente');

-- Expedientes (datos de ejemplo)
INSERT INTO expedientes (id, mascota_id, ultima_consulta, diagnostico_actual, vacunas, proxima_vacuna, proxima_cita, alergias) VALUES
(1, 1, '2026-08-15', 'Infección leve de oído, en tratamiento.',  'Rabia, Moquillo, Parvovirus, Leptospira', 'Refuerzo anual Rabia: 2026-11-15', '2026-09-25 10:00:00', 'Polvo ambiental leve'),
(2, 2, '2026-07-02', 'Sin padecimientos actuales.',             'Rabia, Triple Felina (TCF)',               'Triple Felina: 2026-09-28',   '2026-09-28 12:30:00', NULL),
(3, 3, '2026-08-20', 'Obesidad leve; iniciar dieta controlada.', 'Rabia, Moquillo, Parvovirus',              'Refuerzo anual Rabia: 2027-01-20', NULL, NULL);

-- Historial de consultas (datos de ejemplo)
INSERT INTO historial_consultas (id, expediente_id, mascota_id, veterinario_id, fecha, motivo, diagnostico, tratamiento, receta, notas) VALUES
(1, 1, 1, 1, '2026-08-15 10:00:00', 'Revisión anual',            'Oído derecho con inflamación leve.',          'Limpieza y gotas óticas.', 'Gotas óticas c/12h por 7 días.', 'Se recomienda revalorar en 2 semanas.'),
(2, 2, 2, 2, '2026-07-02 11:00:00', 'Chequeo de rutina',          'Paciente sano.',                              'Ninguno.', 'Ninguna.', 'Ánimo y apetito normales.'),
(3, 3, 3, 3, '2026-08-20 09:30:00', 'Consulta preventiva',        'Peso por encima del ideal para su talla.',      'Cambio a dieta hipocalórica.', 'Alimento light según porción.', 'Control de peso en 30 días.');