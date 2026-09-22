/**
 * Modelo de Servicio veterinario.
 * Corresponde a la tabla "servicios" del backend.
 */
export interface Servicio {
  id: number;
  nombre: string;
  descripcion?: string;
  duracion_min?: number;
  precio_base?: number;
  activo: boolean;
}