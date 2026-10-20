"""Reglas de validación de una solicitud de cita (funciones puras, fáciles de probar)."""
import re
from datetime import date, datetime, time

ESPECIES = {"perro", "gato", "ave", "otro"}
CANALES = {"correo", "telefono", "whatsapp"}
SERVICIOS = {"consulta-general", "vacunacion", "desparasitacion",
             "consulta-preventiva", "control", "basica"}
HORA_APERTURA, HORA_CIERRE = time(8, 0), time(18, 0)

_EMAIL = re.compile(r"^[^@\s]+@[^@\s]+\.[^@\s]+$")
_TELEFONO = re.compile(r"^[0-9 +]{7,15}$")


def validar_correo(valor):
    return bool(_EMAIL.match((valor or "").strip()))


def validar_telefono(valor):
    return bool(_TELEFONO.match((valor or "").strip()))


def validar_fecha(valor, hoy=None):
    """La fecha debe ser ISO (AAAA-MM-DD) y no estar en el pasado."""
    hoy = hoy or date.today()
    try:
        return date.fromisoformat(valor) >= hoy
    except (TypeError, ValueError):
        return False


def validar_horario(valor):
    """La hora (HH:MM) debe estar entre la apertura y el cierre."""
    try:
        hora = datetime.strptime(valor, "%H:%M").time()
    except (TypeError, ValueError):
        return False
    return HORA_APERTURA <= hora <= HORA_CIERRE


def validar_edad(valor):
    try:
        return 0 <= int(valor) <= 20
    except (TypeError, ValueError):
        return False


def validar_cita(datos, hoy=None):
    """Devuelve un dict {campo: mensaje}; vacío si la cita es válida."""
    e = {}
    if len((datos.get("nombre") or "").strip()) < 3:
        e["nombre"] = "El nombre debe tener al menos 3 caracteres."
    if not validar_correo(datos.get("correo")):
        e["correo"] = "Correo electrónico no válido."
    if not validar_telefono(datos.get("telefono")):
        e["telefono"] = "El teléfono debe tener entre 7 y 15 dígitos."
    if datos.get("canal") not in CANALES:
        e["canal"] = "Canal de contacto no válido."
    if not (datos.get("mascota-nombre") or "").strip():
        e["mascota-nombre"] = "Indica el nombre de la mascota."
    if datos.get("especie") not in ESPECIES:
        e["especie"] = "Especie no válida."
    if not validar_edad(datos.get("edad")):
        e["edad"] = "La edad debe estar entre 0 y 20 años."
    if datos.get("servicio") not in SERVICIOS:
        e["servicio"] = "Selecciona un servicio."
    if not validar_fecha(datos.get("fecha"), hoy):
        e["fecha"] = "La fecha no puede estar en el pasado."
    if not validar_horario(datos.get("hora")):
        e["hora"] = "El horario de atención es de 8:00 a 18:00."
    return e
