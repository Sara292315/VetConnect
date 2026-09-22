// ============================================================================
// VETCONNECT - Servicio de servicios veterinarios
// Consulta el catálogo de servicios. Si el backend está desactivado,
// devuelve los datos de ejemplo (mock).
// ============================================================================
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';

import { Servicio } from '../models/servicio.model';
import { API_URL, USAR_DATOS_DE_EJEMPLO } from './api.config';

@Injectable({ providedIn: 'root' })
export class ServicioService {

  constructor(private http: HttpClient) {}

  /** Lista el catálogo de servicios disponibles. */
  obtenerServicios(): Observable<Servicio[]> {
    if (USAR_DATOS_DE_EJEMPLO) {
      return of(this.datosDeEjemplo());
    }
    // Consumo real de la API REST de Laravel: GET /api/v1/servicios
    return this.http
      .get<{ data: Servicio[] }>(`${API_URL}/servicios`)
      .pipe(map((respuesta) => respuesta.data));
  }

  /** Datos de ejemplo alineados con el seed de la base de datos. */
  private datosDeEjemplo(): Servicio[] {
    return [
      {
        id: 1, nombre: 'Consulta general',
        descripcion: 'Revisión completa del estado de salud de la mascota.',
        duracion_min: 30, precio_base: 250, activo: true,
      },
      {
        id: 2, nombre: 'Vacunación',
        descripcion: 'Aplicación de vacunas requeridas según especie y edad.',
        duracion_min: 20, precio_base: 150, activo: true,
      },
      {
        id: 3, nombre: 'Desparasitación',
        descripcion: 'Control de parásitos internos y externos.',
        duracion_min: 20, precio_base: 180, activo: true,
      },
      {
        id: 4, nombre: 'Consulta preventiva',
        descripcion: 'Chequeo preventivo y asesoría de cuidados.',
        duracion_min: 30, precio_base: 220, activo: true,
      },
      {
        id: 5, nombre: 'Control veterinario',
        descripcion: 'Seguimiento de tratamientos y evolución.',
        duracion_min: 20, precio_base: 200, activo: true,
      },
      {
        id: 6, nombre: 'Atención básica',
        descripcion: 'Corte de uñas, limpieza de oídos y cuidados básicos.',
        duracion_min: 25, precio_base: 120, activo: true,
      },
    ];
  }
}