import { Mascota } from './mascota.model';

/**
 * Modelo de Expediente clínico.
 * Corresponde a la tabla "expedientes" del backend.
 */
export interface Expediente {
  id: number;
  mascota_id: number;
  mascota?: Mascota;
  ultima_consulta?: string;
  diagnostico_actual?: string;
  vacunas?: string;
  proxima_vacuna?: string;
  proxima_cita?: string;
  alergias?: string;
  historial_consultas?: HistorialConsulta[];
}

/**
 * Registro dentro del historial de consultas.
 */
export interface HistorialConsulta {
  id: number;
  expediente_id: number;
  mascota_id: number;
  veterinario_id?: number | null;
  fecha: string;
  motivo: string;
  diagnostico?: string;
  tratamiento?: string;
  receta?: string;
  notas?: string;
}