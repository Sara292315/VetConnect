/**
 * Modelo de Veterinario.
 * Corresponde a la tabla "veterinarios" del backend.
 */
export interface Veterinario {
  id: number;
  usuario_id?: number | null;
  nombre_completo: string;
  especialidad?: string;
  telefono?: string;
  correo?: string;
  cedula_profesional?: string;
}