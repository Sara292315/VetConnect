// ============================================================================
// VETCONNECT - Componente de tarjeta de servicio
// Componente reutilizable que muestra cada servicio del catálogo.
// ============================================================================
import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

import { Servicio } from '../../models/servicio.model';

@Component({
  selector: 'app-service-card',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './service-card.component.html',
  styleUrl: './service-card.component.css',
})
export class ServiceCardComponent {
  /** Servicio que se mostrará en la tarjeta. */
  @Input({ required: true }) servicio!: Servicio;
}