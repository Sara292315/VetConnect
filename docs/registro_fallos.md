# Registro de fallos detectados y mantenimiento

| # | Fallo detectado | Tipo | Corrección aplicada |
|---|-----------------|------|---------------------|
| 1 | El formulario de citas usaba `novalidate` y no validaba nada: aceptaba cualquier dato | Corrección (validación) | Validación en cliente (`validators.js`) y en servidor (`validators.py`) |
| 2 | `<output>` de la edad se cerraba con `</o>` (HTML inválido) | Corrección (error de marcado) | Etiqueta cerrada como `</output>` |
| 3 | El envío solo mostraba un `alert()`: la cita no se guardaba | Evolutivo | API Flask + SQLite (`POST /api/citas`) |
| 4 | Se permitían fechas pasadas y horas fuera de 8:00–18:00 | Corrección | `validar_fecha` y `validar_horario` con pruebas de valores límite |
| 5 | Sin pruebas ni integración continua | Preventivo | Batería pytest + GitHub Actions con cobertura mínima del 90 % |

## Mantenimiento propuesto
- Correctivo: ejecutar la suite en cada push (CI) para detectar regresiones.
- Evolutivo: autenticación de propietarios, edición/cancelación de citas y expediente real desde la base de datos.
