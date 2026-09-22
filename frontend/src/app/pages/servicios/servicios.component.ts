// ============================================================================
// VETCONNECT - Página de Servicios
// Muestra el catálogo completo de servicios con tarjetas y una lista resumida.
// ============================================================================
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

import { Servicio } from '../../models/servicio.model';
import { ServicioService } from '../../services/servicio.service';
import { ServiceCardComponent } from '../../components/service-card/service-card.component';

@Component({
  selector: 'app-servicios',
  standalone: true,
  imports: [CommonModule, RouterLink, ServiceCardComponent],
  templateUrl: './servicios.component.html',
  styleUrl: './servicios.component.css',
})
export class ServiciosComponent implements OnInit {

  servicios: Servicio[] = [];

  constructor(private servicioService: ServicioService) {}

  ngOnInit(): void {
    this.servicioService.obtenerServicios().subscribe((servicios) => {
      this.servicios = servicios;
    });
  }
}