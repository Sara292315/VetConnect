// ============================================================================
// VETCONNECT - Página de Contacto
// Muestra los canales de contacto de la veterinaria y un formulario
// sencillo para enviar mensajes (primera versión, sin envío real).
// ============================================================================
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, NgForm } from '@angular/forms';

@Component({
  selector: 'app-contacto',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './contacto.component.html',
  styleUrl: './contacto.component.css',
})
export class ContactoComponent {

  /** Canales de contacto (datos de ejemplo). */
  canales = {
    telefono: '(555) 020-1000',
    whatsapp: '(555) 020-1000',
    correo: 'contacto@vetconnect.com',
    direccion: 'Av. de los Animales 123, Col. Centro, Ciudad de Ejemplo',
    horario: 'Lunes a Sábado, 9:00 - 18:00 hrs',
  };

  /** Modelo del formulario de contacto. */
  mensaje = {
    nombre: '',
    correo: '',
    asunto: '',
    contenido: '',
  };

  /** Confirmación de envío (simulada). */
  enviado = false;

  enviarContacto(formulario: NgForm): void {
    if (formulario.invalid) {
      return;
    }

    // Simula el envío; en la versión con backend se conectará a la API.
    this.enviado = true;
    this.mensaje = { nombre: '', correo: '', asunto: '', contenido: '' };
    formulario.reset();
  }
}