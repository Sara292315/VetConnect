// ============================================================================
// VETCONNECT - Página de Citas
// Formulario HTML5 "Solicitar una cita" con todos los controles requeridos:
// text, email, tel, number, date, time, select, radio, checkbox, textarea,
// submit y reset. Usa validación HTML5 (required, placeholder, min, max).
// ============================================================================
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, NgForm } from '@angular/forms';
import { RouterLink } from '@angular/router';

import { Servicio } from '../../models/servicio.model';
import { Cita } from '../../models/cita.model';
import { ServicioService } from '../../services/servicio.service';
import { CitaService } from '../../services/cita.service';

@Component({
  selector: 'app-citas',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './citas.component.html',
  styleUrl: './citas.component.css',
})
export class CitasComponent implements OnInit {

  /** Catálogo de servicios para el <select>. */
  servicios: Servicio[] = [];

  /** Se obtiene la fecha mínima permitida para la cita (hoy). */
  fechaMinima = new Date().toISOString().split('T')[0];

  /** Modelo del formulario (inicializado con valores vacíos). */
  modelo = {
    nombre_propietario: '',
    correo: '',
    telefono: '',
    nombre_mascota: '',
    especie: 'perro',
    raza: '',
    edad: null as number | null,
    sexo: 'macho',
    servicio_id: null as number | null,
    fecha: '',
    hora: '',
    motivo: '',
    observaciones: '',
    acepta_terminos: false,
  };

  /** Indica si el envío fue exitoso (muestra confirmación). */
  citaConfirmada: Cita | null = null;

  constructor(
    private servicioService: ServicioService,
    private citaService: CitaService,
  ) {}

  ngOnInit(): void {
    this.servicioService.obtenerServicios().subscribe((servicios) => {
      this.servicios = servicios;
    });
  }

  /** Devuelve un objeto con los valores iniciales del formulario. */
  private valoresIniciales() {
    return {
      nombre_propietario: '', correo: '', telefono: '',
      nombre_mascota: '', especie: 'perro', raza: '',
      edad: null as number | null, sexo: 'macho', servicio_id: null as number | null,
      fecha: '', hora: '', motivo: '', observaciones: '',
      acepta_terminos: false,
    };
  }

  /** Limpia los campos del formulario (botón "Limpiar"). */
  limpiarFormulario(formulario: NgForm): void {
    this.citaConfirmada = null;
    this.modelo = this.valoresIniciales();
    formulario.resetForm();
  }

  /** Envío del formulario (ngSubmit con validación HTML5 + Angular). */
  enviarSolicitud(formulario: NgForm): void {
    if (formulario.invalid) {
      // La validación HTML5 ya marca los campos con error.
      return;
    }

    // Se construye la cita con el propietario de demostración (id = 1).
    const cita: Cita = {
      propietario_id: 1,
      mascota_id: 1,
      servicio_id: this.modelo.servicio_id,
      fecha: this.modelo.fecha,
      hora: this.modelo.hora,
      motivo: this.modelo.motivo,
      observaciones: this.modelo.observaciones || undefined,
      estado: 'pendiente',
    };

    this.citaService.solicitarCita(cita).subscribe({
      next: (citaCreada) => {
        // Reinicia el formulario y muestra la confirmación de la cita.
        this.limpiarFormulario(formulario);
        this.citaConfirmada = citaCreada;
      },
      error: () => alert('Ocurrió un problema al solicitar la cita. Inténtalo de nuevo.'),
    });
  }
}