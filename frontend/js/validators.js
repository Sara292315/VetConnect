/* Validaciones del formulario de citas (espejo de backend/validators.py). */
const Validators = (() => {
  const correo = v => /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test((v || '').trim());
  const telefono = v => /^[0-9 +]{7,15}$/.test((v || '').trim());
  const fecha = (v, hoy = new Date().toISOString().slice(0, 10)) => /^\d{4}-\d{2}-\d{2}$/.test(v || '') && v >= hoy;
  const horario = v => /^\d{2}:\d{2}$/.test(v || '') && v >= '08:00' && v <= '18:00';

  function validarCita(d) {
    const e = {};
    if ((d.nombre || '').trim().length < 3) e.nombre = 'El nombre debe tener al menos 3 caracteres.';
    if (!correo(d.correo)) e.correo = 'Correo electrónico no válido.';
    if (!telefono(d.telefono)) e.telefono = 'El teléfono debe tener entre 7 y 15 dígitos.';
    if (!(d['mascota-nombre'] || '').trim()) e['mascota-nombre'] = 'Indica el nombre de la mascota.';
    if (!d.servicio) e.servicio = 'Selecciona un servicio.';
    if (!fecha(d.fecha)) e.fecha = 'La fecha no puede estar en el pasado.';
    if (!horario(d.hora)) e.hora = 'El horario de atención es de 8:00 a 18:00.';
    return e;
  }
  return { correo, telefono, fecha, horario, validarCita };
})();
