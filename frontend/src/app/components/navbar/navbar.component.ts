// ============================================================================
// VETCONNECT - Componente de barra de navegación
// Muestra el logo, el menú de secciones y un botón para solicitar citas.
// El menú es adaptable: se contrae en dispositivos móviles.
// ============================================================================
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterLink, RouterLinkActive],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css',
})
export class NavbarComponent {
  /** Controla la apertura del menú en pantallas pequeñas. */
  menuAbierto = false;

  /** Secciones de la página (navegación). */
  enlaces = [
    { ruta: '/',            etiqueta: 'Inicio' },
    { ruta: '/servicios',   etiqueta: 'Servicios' },
    { ruta: '/citas',       etiqueta: 'Citas' },
    { ruta: '/expediente',  etiqueta: 'Expediente' },
    { ruta: '/veterinaria', etiqueta: 'Veterinaria' },
    { ruta: '/contacto',    etiqueta: 'Contacto' },
  ];

  alternarMenu(): void {
    this.menuAbierto = !this.menuAbierto;
  }

  cerrarMenu(): void {
    this.menuAbierto = false;
  }
}