/**
 * Modelo de Cita (solicitud).
 * Corresponde a la tabla "citas" del backend.
 * Los campos del formulario siguen las reglas establecidas en el
 * FormRequest CitaRequest de Laravel.
 */
export interface Cita {
  id?: number;
  propietario_id: number;
  mascota_id: number;
  servicio_id?: number | null;
  veterinario_id?: number | null;
  fecha: string;          // Formato ISO: "2026-09-25"
  hora: string;           // Formato: "10:00"
  motivo: string;
  observaciones?: string;
  estado: 'pendiente' | 'confirmada' | 'completada' | 'cancelada';
}

/**
 * Datos que el usuario llena en el formulario "Solicitar una cita".
 * Antes de enviarse se mapean a Cita con propietario_id y mascota_id.
 */
export interface FormularioCita {
  nombre_propietario: string;
  correo: string;
  telefono: string;
  nombre_mascota: string;
  especie: string;
  raza: string;
  edad: number | null;
  sexo: string;
  servicio_id: number | null;
  fecha: string;
  hora: string;
  motivo: string;
  observaciones: string;
  acepta_terminos: boolean;
}