// ============================================================================
// VETCONNECT - Página de Veterinaria
// Presenta la información del establecimiento: quiénes somos, fotografías,
// equipo veterinario, horarios de atención y ubicación.
// ============================================================================
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-veterinaria',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './veterinaria.component.html',
  styleUrl: './veterinaria.component.css',
})
export class VeterinariaComponent {

  /** Información del establecimiento (datos de ejemplo). */
  veterinaria = {
    nombre: 'VetConnect Veterinaria Local',
    lema: 'Cuidado profesional con corazón de familia',
    direccion: 'Av. de los Animales 123, Col. Centro, Ciudad de Ejemplo',
    telefono: '(555) 020-1000',
    correo: 'contacto@vetconnect.com',
    horario: 'Lunes a Sábado, 9:00 - 18:00 hrs',
  };

  /** Equipo de veterinarios (datos de ejemplo). */
  equipo = [
    {
      nombre: 'Dr. Andrés Peña',
      especialidad: 'Medicina general / Cirugía menor',
      cedula: 'VET-0001',
    },
    {
      nombre: 'Dra. Sofía Torres',
      especialidad: 'Medicina interna',
      cedula: 'VET-0002',
    },
    {
      nombre: 'Dr. Luis Herrera',
      especialidad: 'Atención preventiva / Vacunación',
      cedula: 'VET-0003',
    },
  ];

  /** Horarios de la semana. */
  horarios = [
    { dia: 'Lunes a Viernes', horas: '9:00 - 18:00 hrs' },
    { dia: 'Sábados', horas: '9:00 - 14:00 hrs' },
    { dia: 'Domingos y días festivos', horas: 'Cerrado' },
  ];
}