/**
 * Modelo de Mascota (paciente).
 * Corresponde a la tabla "mascotas" del backend.
 */
export interface Mascota {
  id: number;
  propietario_id: number;
  nombre: string;
  especie: 'perro' | 'gato' | 'ave' | 'roedor' | 'otro';
  raza?: string;
  edad_anios?: number;
  sexo: 'macho' | 'hembra' | 'desconocido';
  color?: string;
  peso_kg?: number;
}