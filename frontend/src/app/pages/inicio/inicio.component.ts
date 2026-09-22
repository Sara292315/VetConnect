// ============================================================================
// VETCONNECT - Página de Inicio
// Presenta la plataforma, sus beneficios, un adelanto de servicios y
// la información básica de la veterinaria.
// ============================================================================
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

import { Servicio } from '../../models/servicio.model';
import { ServicioService } from '../../services/servicio.service';
import { ServiceCardComponent } from '../../components/service-card/service-card.component';

@Component({
  selector: 'app-inicio',
  standalone: true,
  imports: [CommonModule, RouterLink, ServiceCardComponent],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css',
})
export class InicioComponent implements OnInit {

  /** Servicios destacados que se muestran en el inicio. */
  serviciosDestacados: Servicio[] = [];

  constructor(private servicioService: ServicioService) {}

  ngOnInit(): void {
    // Se muestran los tres primeros servicios del catálogo.
    this.servicioService.obtenerServicios().subscribe((servicios) => {
      this.serviciosDestacados = servicios.slice(0, 3);
    });
  }

  /** Horarios de atención para la sección informativa. */
  horarios = [
    { dia: 'Lunes a Viernes', horas: '9:00 - 18:00 hrs' },
    { dia: 'Sábados', horas: '9:00 - 14:00 hrs' },
    { dia: 'Domingos', horas: 'Cerrado' },
  ];
}