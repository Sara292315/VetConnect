// ============================================================================
// VETCONNECT - Servicio de citas
// Permite solicitar y consultar citas veterinarias.
// Si el backend está desactivado, usa los datos de ejemplo (mock).
// ============================================================================
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';

import { Cita } from '../models/cita.model';
import { API_URL, USAR_DATOS_DE_EJEMPLO } from './api.config';

@Injectable({ providedIn: 'root' })
export class CitaService {

  constructor(private http: HttpClient) {}

  /** Solicita una nueva cita (POST /api/v1/citas). */
  solicitarCita(cita: Cita): Observable<Cita> {
    if (USAR_DATOS_DE_EJEMPLO) {
      // En modo demo se asigna un id simulado y estado "pendiente".
      const citaNueva: Cita = { ...cita, id: 100, estado: 'pendiente' };
      return of(citaNueva);
    }
    return this.http
      .post<{ message: string; data: Cita }>(`${API_URL}/citas`, cita)
      .pipe(map((respuesta) => respuesta.data));
  }

  /** Obtiene las citas de un propietario (GET /api/v1/citas). */
  obtenerCitas(): Observable<Cita[]> {
    if (USAR_DATOS_DE_EJEMPLO) {
      return of(this.datosDeEjemplo());
    }
    return this.http
      .get<{ data: Cita[] }>(`${API_URL}/citas`)
      .pipe(map((respuesta) => respuesta.data));
  }

  /** Datos de ejemplo para el expediente y las próximas citas. */
  private datosDeEjemplo(): Cita[] {
    return [
      {
        id: 1, propietario_id: 1, mascota_id: 1, servicio_id: 1,
        veterinario_id: 1, fecha: '2026-09-25', hora: '10:00',
        motivo: 'Chequeo general y tos persistente',
        observaciones: 'Rex ha presentado tos por las mañanas.',
        estado: 'confirmada',
      },
      {
        id: 2, propietario_id: 1, mascota_id: 2, servicio_id: 2,
        veterinario_id: 2, fecha: '2026-09-28', hora: '12:30',
        motivo: 'Refuerzo de vacuna',
        observaciones: 'Misha requiere dosis anual.',
        estado: 'pendiente',
      },
    ];
  }
}