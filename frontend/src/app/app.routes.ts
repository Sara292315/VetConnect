// ============================================================================
// VETCONNECT - Definición de rutas (navegación entre secciones)
// ============================================================================
import { Routes } from '@angular/router';

import { InicioComponent } from './pages/inicio/inicio.component';
import { ServiciosComponent } from './pages/servicios/servicios.component';
import { CitasComponent } from './pages/citas/citas.component';
import { ExpedienteComponent } from './pages/expediente/expediente.component';
import { VeterinariaComponent } from './pages/veterinaria/veterinaria.component';
import { ContactoComponent } from './pages/contacto/contacto.component';
import { TycComponent } from './pages/tyc/tyc.component';

/**
 * Rutas de la primera versión:
 * 1. Inicio
 * 2. Servicios
 * 3. Citas
 * 4. Expediente
 * 5. Veterinaria
 * 6. Contacto
 * 7. Términos y condiciones
 */
export const routes: Routes = [
  { path: '',             component: InicioComponent,       title: 'Inicio - VetConnect' },
  { path: 'servicios',    component: ServiciosComponent,    title: 'Servicios - VetConnect' },
  { path: 'citas',        component: CitasComponent,        title: 'Solicitar cita - VetConnect' },
  { path: 'expediente',   component: ExpedienteComponent,   title: 'Expediente - VetConnect' },
  { path: 'veterinaria',  component: VeterinariaComponent,  title: 'Veterinaria - VetConnect' },
  { path: 'contacto',     component: ContactoComponent,     title: 'Contacto - VetConnect' },
  { path: 'terminos',     component: TycComponent,          title: 'Términos y condiciones - VetConnect' },
  // Ruta comodín: cualquier URL desconocida lleva al inicio.
  { path: '**',           redirectTo: '', pathMatch: 'full' },
];