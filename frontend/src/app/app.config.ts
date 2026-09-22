// ============================================================================
// VETCONNECT - Configuración de la aplicación (standalone components)
// ============================================================================
import { ApplicationConfig, provideZoneChangeDetection } from '@angular/core';
import { provideRouter } from '@angular/router';
import { provideHttpClient } from '@angular/common/http';

import { routes } from './app.routes';

/**
 * Configuración raíz: enruta las páginas y habilita HttpClient
 * para que los servicios de datos puedan consumir la API REST de Laravel.
 */
export const appConfig: ApplicationConfig = {
  providers: [
    provideZoneChangeDetection({ eventCoalescing: true }),
    provideRouter(routes),
    provideHttpClient(),
  ],
};