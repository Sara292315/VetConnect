/**
 * Configuración de acceso a la API REST (backend Laravel).
 *
 * Cuando el backend esté activo en XAMPP (php artisan serve --port=8000),
 * el frontend consumirá: http://localhost:8000/api/v1/...
 */
export const API_URL = 'http://localhost:8000/api/v1';

/**
 * Bandera de funcionamiento de la primera versión.
 *
 * true  -> Se utilizan datos de ejemplo (mock) para que el frontend
 *          funcione sin necesidad del backend.
 * false -> Se consumen los endpoints reales de Laravel.
 *
 * Para demostrar la conexión con la API, cambie a false y ejecute el backend.
 */
export const USAR_DATOS_DE_EJEMPLO = true;