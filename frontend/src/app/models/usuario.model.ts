/**
 * Modelo de Usuario / Propietario.
 * Corresponde a la tabla "usuarios" del backend.
 */
export interface Usuario {
  id: number;
  nombre_completo: string;
  correo: string;
  telefono?: string;
  tipo_usuario: 'propietario' | 'veterinario' | 'administrativo';
}

/**
 * Datos que el formulario de citas envía al backend.
 */
export interface DatosPropietario {
  nombre_completo: string;
  correo: string;
  telefono: string;
}