// ============================================================================
// VETCONNECT - Página de Términos y Condiciones
// Documento legal simplificado del uso de la plataforma (versión académica).
// ============================================================================
import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-tyc',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './tyc.component.html',
  styleUrl: './tyc.component.css',
})
export class TycComponent {
  /** Datos del documento (para la última actualización). */
  actualizacion = '21 de septiembre de 2026';
}