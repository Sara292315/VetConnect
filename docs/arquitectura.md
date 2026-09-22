# Arquitectura de VetConnect

**Documento de arquitectura** — Plataforma de Citas y Expediente para
Veterinarias Locales.

VetConnect sigue una **arquitectura en capas**. Cada capa tiene una
responsabilidad única y se comunica únicamente con la capa inmediata inferior,
lo que permite separar la interfaz de usuario, las reglas de negocio, el acceso
a datos y el almacenamiento.

---

## Diagrama general

```
      ┌─────────────────────────────────────────────────────────┐
      │                        USUARIO                          │
      │              (propietario / veterinario / personal)     │
      └──────────────────────────┬──────────────────────────────┘
                                 │  interacción (navegador)
                                 ▼
   ┌─────────────────────────────────────────────────────────────┐
   │ CAPA 1 · PRESENTACIÓN                                        │
   │ Angular + TypeScript + HTML5 + CSS3 + JavaScript             │
   │ Interfaz, menús, formularios, botones y navegación           │
   └──────────────────────────┬──────────────────────────────────┘
                              │  solicitudes HTTP (JSON)
                              ▼
   ┌─────────────────────────────────────────────────────────────┐
   │ API REST (HTTP)                                             │
   │ Recursos: /api/v1/servicios, /mascotas, /citas, ...         │
   └──────────────────────────┬──────────────────────────────────┘
                              ▼
   ┌─────────────────────────────────────────────────────────────┐
   │ CAPA 2 · LÓGICA DE NEGOCIO                                   │
   │ Laravel: Controllers + Services + Form Requests             │
   │ Procesar solicitudes, validar y aplicar reglas de negocio   │
   └──────────────────────────┬──────────────────────────────────┘
                              ▼
   ┌─────────────────────────────────────────────────────────────┐
   │ CAPA 3 · ACCESO A DATOS                                      │
   │ Laravel: Models (Eloquent ORM)                               │
   │ Consultar, insertar, actualizar y eliminar datos            │
   └──────────────────────────┬──────────────────────────────────┘
                              ▼
   ┌─────────────────────────────────────────────────────────────┐
   │ CAPA 4 · BASE DE DATOS                                       │
   │ MySQL  (database/vetconnect.sql)                             │
   └─────────────────────────────────────────────────────────────┘
```

---

## CAPA 1 · Presentación

**Tecnologías:** HTML5, CSS3, JavaScript, Angular 17, TypeScript.

**Ubicación:** carpeta `frontend/`.

**Responsabilidades:**

- Construir la interfaz de usuario (diseño propio, sin Bootstrap).
- Mostrar el menú de navegación entre las secciones de la página.
- Presentar los formularios de solicitud de citas y contacto.
- Mostrar el catálogo de servicios, la información de la veterinaria,
  el expediente y el historial de consultas.
- Validar los campos con los controles de HTML5 (`required`, `min`, `max`,
  tipos `email`, `tel`, `number`, `date`, `time`, etc.).

**Reglas de arquitectura:**

- No conoce ni se conecta directamente a la base de datos.
- Toda la información se obtiene a través de los *services* de Angular
  (`services/cita.service.ts`, `services/mascota.service.ts`,
  `services/servicio.service.ts`), que consumen la **API REST**.
- En la primera versión, los servicios pueden operar con **datos de ejemplo**
  (`api.config.ts`, `USAR_DATOS_DE_EJEMPLO`) para que el frontend funcione sin
  backend.

**Estructura de la capa:**

| Ruta                          | Contenido                                     |
| ----------------------------- | --------------------------------------------- |
| `frontend/src/app/pages/`     | Páginas (inicio, servicios, citas, expediente, veterinaria, contacto, tyc) |
| `frontend/src/app/components/`| Componentes reutilizables (navbar, footer, service-card) |
| `frontend/src/app/services/`  | Clientes HTTP hacia la API                    |
| `frontend/src/app/models/`    | Interfaces de datos (mismas entidades del backend) |
| `frontend/src/assets/`        | Imágenes e ilustraciones                      |
| `frontend/src/styles/`        | Sistema de diseño CSS3                        |

---

## CAPA 2 · Lógica de negocio

**Tecnologías:** PHP 8, Laravel 11, API REST.

**Ubicación:** carpeta `backend/app/`.

**Responsabilidades:**

- Recibir y dar respuesta a las solicitudes del frontend mediante
  **Controllers** (`backend/app/Http/Controllers/`).
- Validar la información recibida mediante **Form Requests**
  (`backend/app/Http/Requests/CitaRequest.php`, `MascotaRequest.php`).
- Aplicar las **reglas de negocio** mediante **Services**
  (`backend/app/Services/`).

**Ejemplos de reglas de negocio aplicadas en `CitaService`:**

| Regla                                                            | Archivo                                          |
| ---------------------------------------------------------------- | ------------------------------------------------ |
| La fecha de la cita no puede ser anterior a hoy.                  | `app/Services/CitaService.php` (`validarFechaFutura`) |
| Solo se agendan citas en horario laboral (9:00 - 18:00 hrs).      | `app/Services/CitaService.php` (`validarHorarioLaboral`) |
| La mascota debe pertenecer al propietario que solicita la cita.   | `app/Services/CitaService.php` (`agendar`)       |
| No se permite duplicar una cita para la misma mascota, fecha y hora. | `app/Services/CitaService.php` (`agendar`)    |
| El estado de la cita debe ser uno de los estados permitidos.      | `app/Services/CitaService.php` (`actualizarEstado`) |
| Toda mascota registrada inicia con un expediente.                 | `app/Services/MascotaService.php` (`registrar`)  |

**Flujo típico - solicitud de cita:**

```
POST /api/v1/citas
  1. Laravel enruta la petición hacia CitaController@store (routes/api.php).
  2. CitaRequest valida los campos (fecha, hora, motivos, relaciones…).
  3. CitaService@agendar aplica las reglas de negocio dentro de una transacción.
  4. Si todo es correcto, encarga la persistencia al Modelo (Capa 3).
  5. Se devuelve la respuesta JSON (201 Created) al frontend.
```

---

## CAPA 3 · Acceso a datos

**Tecnologías:** Laravel Eloquent ORM.

**Ubicación:** carpeta `backend/app/Models/`.

**Responsabilidades:**

- Comunicarse exclusivamente con la base de datos.
- Consultar, insertar, actualizar y eliminar registros.
- Definir las **relaciones** entre entidades (pertenece a, tiene muchos,
  tiene uno).
- Representar cada tabla como un modelo.

**Modelos y relaciones:**

| Modelo               | Tabla                  | Relaciones principales                    |
| -------------------- | ---------------------- | ----------------------------------------- |
| `Usuario`            | `usuarios`             | `mascotas()`, `citas()`                   |
| `Veterinario`        | `veterinarios`         | `usuario()`, `citas()`                    |
| `Mascota`            | `mascotas`             | `propietario()`, `expediente()` (1:1), `citas()` |
| `Servicio`           | `servicios`            | `citas()`                                 |
| `Cita`               | `citas`                | `propietario()`, `mascota()`, `veterinario()`, `servicio()` |
| `Expediente`         | `expedientes`          | `mascota()` (1:1), `historialConsultas()` |
| `HistorialConsulta`  | `historial_consultas`  | `expediente()`, `mascota()`, `veterinario()` |

**Reglas de arquitectura:**

- La lógica de negocio **nunca** ejecuta consultas SQL directamente.
- La capa de acceso a datos está separada de la lógica de negocio: los
  *Services* piden a los *Models* la persistencia y los *Controllers* no
  manipulan bases de datos.

---

## CAPA 4 · Base de datos

**Tecnología:** MySQL.

**Ubicación:**

- Script completo: `database/vetconnect.sql`.
- Migraciones Laravel: `backend/database/migrations/`.
- Datos de ejemplo: `backend/database/seeders/DatabaseSeeder.php`.

**Estructura:**

```
usuarios ──< mascotas ──< expedientes ──< historial_consultas
   │            │             
   │            └──< citas >── veterinarios
   └──────────────< citas >── servicios
```

- **Claves primarias** (`id`) en todas las tablas.
- **Claves foráneas** con integridad referencial y reglas `ON DELETE`
  (`CASCADE` / `SET NULL`).
- Índices para búsqueda rápida (por ejemplo, `idx_citas_fecha (fecha, estado)`,
  `idx_mascotas_nombre (nombre)`).
- Motor `InnoDB` y codificación `utf8mb4`.

---

## Comunicación entre capas

| De                                             | A                                              | Mecanismo                 |
| ---------------------------------------------- | ---------------------------------------------- | ------------------------- |
| Navegador (usuario)                            | Frontend Angular                               | Interfaz / eventos        |
| Frontend (Angular `HttpClient`)                | API REST (Laravel)                             | JSON sobre HTTP           |
| Controller (Laravel)                           | Service (Laravel)                              | Inyección de dependencias |
| Service (Laravel)                              | Model (Eloquent)                               | Métodos del ORM           |
| Model (Eloquent)                               | MySQL                                          | Conexión de base de datos |

---

## Beneficios del diseño por capas

1. **Separación de responsabilidades:** cada capa solo sabe resolver su propio
   problema.
2. **Mantenimiento:** los cambios en la interfaz no afectan las reglas de
   negocio ni a MySQL.
3. **Reutilización:** el mismo backend puede servir a una app web y, en el
   futuro, a apps móviles.
4. **Evolución:** la base de datos puede cambiarse (por ejemplo, PostgreSQL) sin
   tocar la interfaz.
5. **Escalabilidad académica a profesional:** la estructura permite crecer a
   autenticación, pagos, notificaciones y más módulos.

---

Proyecto académico de Ingeniería de Software — VetConnect 1.0.0.