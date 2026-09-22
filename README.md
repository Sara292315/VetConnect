# VETCONNECT

**"Plataforma de Citas y Expediente para Veterinarias Locales"**

Primera versión funcional de una aplicación web académica que facilita la gestión
de citas veterinarias y la organización de la información básica de las mascotas
para pequeñas y medianas veterinarias locales.

---

## Índice

1. [Descripción del proyecto](#1-descripción-del-proyecto)
2. [Problema](#2-problema)
3. [Objetivo](#3-objetivo)
4. [Usuarios](#4-usuarios)
5. [Tecnologías](#5-tecnologías)
6. [Arquitectura en capas](#6-arquitectura-en-capas)
7. [Estructura de carpetas](#7-estructura-de-carpetas)
8. [Instalación](#8-instalación)
9. [Ejecución](#9-ejecución)
10. [Base de datos](#10-base-de-datos)
11. [Funcionalidades de la versión 1](#11-funcionalidades-de-la-versión-1)
12. [Validaciones HTML5](#12-validaciones-html5)
13. [Futuras mejoras](#13-futuras-mejoras)

---

## 1. Descripción del proyecto

VetConnect es una plataforma web orientada a veterinarias locales que permite:

- Consultar información de la veterinaria, sus servicios y horarios.
- Solicitar citas en línea con un formulario HTML5 completo.
- Consultar el expediente y el historial de consultas de una mascota.
- Centralizar la información de mascotas, citas y expedientes.

El proyecto inicia como un prototipo académico, pero está estructurado en capas
para poder convertirse posteriormente en una aplicación web completa.

## 2. Problema

Actualmente algunas veterinarias locales gestionan sus citas mediante llamadas
telefónicas, WhatsApp, agendas físicas o registros manuales. Esto ocasiona:

- Dificultad para organizar las citas.
- Pérdida o desorden de la información.
- Dificultad para consultar el historial de una mascota.
- Problemas para recordar próximas citas.
- Falta de centralización de la información.
- Dificultad para que los propietarios conozcan servicios y horarios.

## 3. Objetivo

Desarrollar una primera versión de VetConnect que demuestre el uso de **HTML5**,
**CSS3**, **JavaScript**, **Angular/TypeScript**, **PHP/Laravel (API REST)** y
**MySQL**, organizada con una **arquitectura en capas** y separación de
responsabilidades, con una complejidad apropiada para un proyecto académico.

## 4. Usuarios

- Propietarios de mascotas.
- Veterinarios.
- Personal administrativo de veterinarias.
- Pequeñas y medianas veterinarias locales.

La interfaz está diseñada para ser sencilla e intuitiva para usuarios con
diferentes niveles de conocimiento tecnológico.

## 5. Tecnologías

| Capa            | Tecnologías                              |
| --------------- | ---------------------------------------- |
| Presentación    | HTML5, CSS3, JavaScript, Angular, TypeScript |
| Lógica negocio  | PHP, Laravel, API REST                 |
| Acceso a datos  | Laravel (Eloquent ORM), PDO               |
| Base de datos   | MySQL                                     |
| Herramientas    | Visual Studio Code, Git, GitHub, XAMPP    |

> El frontend **no** se conecta directamente a MySQL; todo intercambio de datos
> ocurre a través de la API REST del backend.

## 6. Arquitectura en capas

```
USUARIO
   ↓
FRONTEND / CAPA DE PRESENTACIÓN   (Angular + HTML5 + CSS3)
   ↓
API REST                          (JSON sobre HTTP)
   ↓
BACKEND / LÓGICA DE NEGOCIO       (Laravel: Controllers + Services)
   ↓
CAPA DE ACCESO A DATOS            (Laravel: Models / Eloquent)
   ↓
BASE DE DATOS                     (MySQL)
```

Cada capa tiene una responsabilidad única. Consulte el documento
[`docs/arquitectura.md`](docs/arquitectura.md) para la explicación detallada.

## 7. Estructura de carpetas

```
VetConnect/
│
├── frontend/                        # CAPA DE PRESENTACIÓN (Angular 17)
│   ├── src/
│   │   ├── app/
│   │   │   ├── components/          # navbar, footer, service-card
│   │   │   ├── pages/               # inicio, servicios, citas, expediente,
│   │   │   │                        # veterinaria, contacto, tyc
│   │   │   ├── services/            # cita, mascota, servicio + api.config
│   │   │   └── models/              # usuario, mascota, cita, servicio,
│   │   │                            # expediente, veterinario
│   │   ├── assets/images/           # ilustraciones SVG propias
│   │   └── styles/                  # sistema de diseño CSS3
│   │   ├── index.html
│   │   └── main.ts
│   ├── angular.json
│   ├── tsconfig.json
│   └── package.json
│
├── backend/                         # CAPAS DE LÓGICA + ACCESO A DATOS (Laravel 11)
│   ├── app/
│   │   ├── Models/                  # 7 modelos Eloquent
│   │   ├── Http/
│   │   │   ├── Controllers/         # cita, mascota, expediente, servicio
│   │   │   └── Requests/            # Validación (CitaRequest, MascotaRequest)
│   │   └── Services/                # Reglas de negocio
│   ├── routes/
│   │   └── api.php                  # Endpoints REST /api/v1
│   └── database/
│       ├── migrations/              # Creación de las 7 tablas
│       └── seeders/                 # DatabaseSeeder con datos de ejemplo
│
├── database/
│   └── vetconnect.sql               # Script SQL completo (MySQL)
│
├── docs/
│   └── arquitectura.md              # Documento de arquitectura en capas
│
├── .gitignore
└── README.md
```

## 8. Instalación

### Requisitos previos

- **Node.js** 18+ y npm (para el frontend Angular).
- **PHP** 8.1+ y **Composer** (para el backend Laravel).
- **XAMPP** (Apache + MySQL) o equivalente.

### 8.1 Base de datos

1. Abrir **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Importar el archivo [`database/vetconnect.sql`](database/vetconnect.sql).
   Esto crea la base de datos `vetconnect` con todas las tablas, claves
   primarias/foráneas y datos de ejemplo.

### 8.2 Backend (Laravel)

```bash
# Crear el esqueleto de Laravel (solo la primera vez)
composer create-project laravel/laravel backend

# Copiar los archivos de este proyecto a la instalación:
#   backend/app/Models/*.php
#   backend/app/Http/Controllers/*.php
#   backend/app/Http/Requests/*.php
#   backend/app/Services/*.php
#   backend/routes/api.php
#   backend/database/migrations/*.php
#   backend/database/seeders/*.php

# Configurar la conexión en backend/.env
#   DB_CONNECTION=mysql
#   DB_HOST=127.0.0.1
#   DB_PORT=3306
#   DB_DATABASE=vetconnect
#   DB_USERNAME=root
#   DB_PASSWORD=

# Ejecutar migraciones y datos de ejemplo
cd backend
php artisan migrate --seed
```

> **Alternativa:** como XAMPP ya tiene los archivos, si prefieres crear las
> tablas con el script SQL, ejecuta `php artisan migrate` después de importar
> `database/vetconnect.sql`.

### 8.3 Frontend (Angular)

```bash
cd frontend
npm install
```

## 9. Ejecución

### Backend

```bash
cd backend
php artisan serve          # http://localhost:8000
```

La API quedará disponible en `http://localhost:8000/api/v1/...`.
Puede probarla con:

```bash
curl http://localhost:8000/api/v1/servicios
curl -X POST http://localhost:8000/api/v1/citas \
  -H "Content-Type: application/json" \
  -d '{"propietario_id":1,"mascota_id":1,"servicio_id":1,"fecha":"2099-01-01","hora":"10:00","motivo":"Chequeo"}'
```

### Frontend

```bash
cd frontend
npm start                    # ng serve  →  http://localhost:4200
```

> En la **primera versión** el frontend usa **datos de ejemplo (mock)** para que
> la interfaz funcione sin backend. Para conectarlo a la API real, abra
> `src/app/services/api.config.ts` y cambie `USAR_DATOS_DE_EJEMPLO = false`.

## 10. Base de datos

Tablas creadas (con claves primarias y foráneas):

| Tabla                  | Descripción                              |
| ---------------------- | ---------------------------------------- |
| `usuarios`             | Propietarios y personal                  |
| `veterinarios`         | Profesionales de la veterinaria          |
| `mascotas`             | Pacientes (especie, raza, edad, sexo…)   |
| `servicios`            | Catálogo de servicios                    |
| `citas`                | Solicitudes de cita                      |
| `expedientes`          | Expediente clínico (1:1 con mascotas)    |
| `historial_consultas`  | Registro histórico de consultas          |

Relaciones principales:

- `mascotas.propietario_id → usuarios.id`
- `citas.propietario_id → usuarios.id`, `citas.mascota_id → mascotas.id`
- `citas.veterinario_id → veterinarios.id`, `citas.servicio_id → servicios.id`
- `expedientes.mascota_id → mascotas.id` (única)
- `historial_consultas.expediente_id → expedientes.id`

## 11. Funcionalidades de la versión 1

- Navegación entre las 7 secciones de la página.
- Consulta del catálogo de servicios (tarjetas y tabla comparativa).
- Formulario **"Solicitar una cita"** con controles HTML5 y validación.
- Visualización del **expediente de la mascota** (tabla e historial de ejemplo).
- Información de la veterinaria, equipo, horarios y ubicación.
- Formulario de contacto (simulado).
- Términos y condiciones.
- Diseño **responsive** (computadora, tableta y celular) sin Bootstrap.

## 12. Validaciones HTML5

El formulario de citas demuestra los siguientes controles y atributos:

- `text`, `email`, `tel`, `number`, `date`, `time`, `select`, `radio`,
  `checkbox`, `textarea`, `submit`, `reset`.
- `required`, `placeholder`, `min`, `max`, `id`, `name`, `for`.
- Además del `pattern` para teléfono y `maxlength` para motivos/observaciones.

## 13. Futuras mejoras

- Autenticación y registro de usuarios (JWT / Sanctum).
- Panel de administración para la veterinaria (CRUD de citas).
- Notificaciones por correo y recordatorios de citas.
- Subida de imágenes de mascotas.
- Generación de PDF del expediente.
- Registro de pagos y facturación de servicios.
- Despliegue en un servidor (frontend + API + base de datos).

---

Proyecto académico de Ingeniería de Software. Los datos mostrados son ficticios.