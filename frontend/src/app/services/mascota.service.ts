// ============================================================================
// VETCONNECT - Servicio de mascotas y expedientes
// Proporciona la información del paciente y su expediente clínico.
// Si el backend está desactivado, usa los datos de ejemplo (mock).
// ============================================================================
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';

import { Mascota } from '../models/mascota.model';
import { Expediente } from '../models/expediente.model';
import { API_URL, USAR_DATOS_DE_EJEMPLO } from './api.config';

@Injectable({ providedIn: 'root' })
export class MascotaService {

  constructor(private http: HttpClient) {}

  /** Lista las mascotas de un propietario (GET /api/v1/mascotas). */
  obtenerMascotas(): Observable<Mascota[]> {
    if (USAR_DATOS_DE_EJEMPLO) {
      return of(this.mascotasDeEjemplo());
    }
    return this.http
      .get<{ data: Mascota[] }>(`${API_URL}/mascotas`)
      .pipe(map((respuesta) => respuesta.data));
  }

  /** Obtiene el expediente de una mascota (GET /api/v1/mascotas/{id}/expediente). */
  obtenerExpediente(mascotaId: number): Observable<Expediente | null> {
    if (USAR_DATOS_DE_EJEMPLO) {
      return of(this.expedienteDeEjemplo(mascotaId));
    }
    return this.http
      .get<{ data: Expediente }>(`${API_URL}/mascotas/${mascotaId}/expediente`)
      .pipe(map((respuesta) => respuesta.data));
  }

  /** Mascotas ficticias (primera versión). */
  private mascotasDeEjemplo(): Mascota[] {
    return [
      {
        id: 1, propietario_id: 1, nombre: 'Rex', especie: 'perro',
        raza: 'Labrador Retriever', edad_anios: 4, sexo: 'macho',
        color: 'Dorado', peso_kg: 32.5,
      },
      {
        id: 2, propietario_id: 1, nombre: 'Misha', especie: 'gato',
        raza: 'Siamés', edad_anios: 3, sexo: 'hembra', color: 'Crema / Café',
        peso_kg: 4.2,
      },
      {
        id: 3, propietario_id: 2, nombre: 'Luna', especie: 'perro',
        raza: 'Mestizo', edad_anios: 2, sexo: 'hembra',
        color: 'Negro y blanco', peso_kg: 12.8,
      },
    ];
  }

  /** Expediente ficticio (el usuario 1 tiene hijas ejemplares Rex y Misha). */
  private expedienteDeEjemplo(mascotaId: number): Expediente | null {
    const exp: Record<number, Expediente> = {
      1: {
        id: 1, mascota_id: 1,
        ultima_consulta: '2026-08-15',
        diagnostico_actual: 'Infección leve de oído, en tratamiento.',
        vacunas: 'Rabia, Moquillo, Parvovirus, Leptospira',
        proxima_vacuna: 'Refuerzo anual Rabia: 2026-11-15',
        proxima_cita: '2026-09-25 10:00:00',
        alergias: 'Polvo ambiental leve',
        historial_consultas: [
          {
            id: 1, expediente_id: 1, mascota_id: 1, veterinario_id: 1,
            fecha: '2026-08-15 10:00:00', motivo: 'Revisión anual',
            diagnostico: 'Oído derecho con inflamación leve.',
            tratamiento: 'Limpieza y gotas óticas.',
            receta: 'Gotas óticas c/12h por 7 días.',
            notas: 'Se recomienda revalorar en 2 semanas.',
          },
        ],
      },
      2: {
        id: 2, mascota_id: 2,
        ultima_consulta: '2026-07-02',
        diagnostico_actual: 'Sin padecimientos actuales.',
        vacunas: 'Rabia, Triple Felina (TCF)',
        proxima_vacuna: 'Triple Felina: 2026-09-28',
        proxima_cita: '2026-09-28 12:30:00',
        alergias: undefined,
        historial_consultas: [
          {
            id: 2, expediente_id: 2, mascota_id: 2, veterinario_id: 2,
            fecha: '2026-07-02 11:00:00', motivo: 'Chequeo de rutina',
            diagnostico: 'Paciente sano.', tratamiento: 'Ninguno.',
            receta: 'Ninguna.', notas: 'Ánimo y apetito normales.',
          },
        ],
      },
    };

    return exp[mascotaId] ?? null;
  }
}