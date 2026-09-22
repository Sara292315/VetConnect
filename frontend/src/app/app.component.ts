// ============================================================================
// VETCONNECT - Componente raíz
// Envuelve la navegación, el contenido de cada página (router-outlet)
// y el pie de página común a toda la aplicación.
// ============================================================================
import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';

import { NavbarComponent } from './components/navbar/navbar.component';
import { FooterComponent } from './components/footer/footer.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, NavbarComponent, FooterComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css',
})
export class AppComponent {
  title = 'VetConnect';
}