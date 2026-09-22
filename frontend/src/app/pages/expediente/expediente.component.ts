// ============================================================================
// VETCONNECT - Página de Expediente
// Muestra el expediente de la mascota seleccionada: datos generales,
// tabla del expediente, próximas vacunas e historial de consultas.
// Los datos mostrados son ficticios (datos de ejemplo) para la versión 1.
// ============================================================================
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { Mascota } from '../../models/mascota.model';
import { Expediente } from '../../models/expediente.model';
import { MascotaService } from '../../services/mascota.service';

@Component({
  selector: 'app-expediente',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './expediente.component.html',
  styleUrl: './expediente.component.css',
})
export class ExpedienteComponent implements OnInit {

  /** Mascotas del propietario de ejemplo. */
  mascotas: Mascota[] = [];

  /** Mascota seleccionada en el <select>. */
  mascotaId = 1;

  /** Expediente de la mascota seleccionada. */
  expediente: Expediente | null = null;

  /** Indica si la mascota seleccionada no tiene expediente. */
  sinExpediente = false;

  constructor(private mascotaService: MascotaService) {}

  ngOnInit(): void {
    this.mascotaService.obtenerMascotas().subscribe((mascotas) => {
      this.mascotas = mascotas;
      this.cargarExpediente();
    });
  }

  /** Cambia el expediente cuando el usuario elige otra mascota. */
  seleccionarMascota(): void {
    this.cargarExpediente();
  }

  /** Consulta el expediente de la mascota activa. */
  cargarExpediente(): void {
    this.mascotaService.obtenerExpediente(this.mascotaId).subscribe((expediente) => {
      this.expediente = expediente;
      this.sinExpediente = !expediente;
    });
  }

  /** Auxiliar de presentación: primer nombre de la mascota. */
  get nombreMascotaActual(): string {
    return this.mascotas.find((m) => m.id === this.mascotaId)?.nombre ?? 'la mascota';
  }
}