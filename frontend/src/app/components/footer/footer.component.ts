// ============================================================================
// VETCONNECT - Pie de página
// Muestra la marca, enlaces rápidos, información de contacto y un enlace
// hacia los términos y condiciones.
// ============================================================================
import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.css',
})
export class FooterComponent {
  anio = new Date().getFullYear();
}