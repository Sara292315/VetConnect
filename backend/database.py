"""Capa de persistencia (SQLite)."""
import sqlite3

CAMPOS = ("nombre", "correo", "telefono", "canal", "mascota", "especie", "raza",
          "edad", "sexo", "servicio", "fecha", "hora", "motivo", "observaciones")


def _conectar(ruta):
    con = sqlite3.connect(ruta)
    con.row_factory = sqlite3.Row
    return con


def init_db(ruta):
    with _conectar(ruta) as con:
        con.execute("""CREATE TABLE IF NOT EXISTS citas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL, correo TEXT NOT NULL, telefono TEXT NOT NULL,
            canal TEXT, mascota TEXT NOT NULL, especie TEXT, raza TEXT, edad INTEGER,
            sexo TEXT, servicio TEXT NOT NULL, fecha TEXT NOT NULL, hora TEXT NOT NULL,
            motivo TEXT, observaciones TEXT)""")


def guardar_cita(ruta, d):
    valores = (d["nombre"].strip(), d["correo"].strip(), d["telefono"].strip(),
               d.get("canal"), d["mascota-nombre"].strip(), d.get("especie"),
               d.get("raza", ""), int(d["edad"]), d.get("sexo"), d["servicio"],
               d["fecha"], d["hora"], d.get("motivo", ""), d.get("observaciones", ""))
    with _conectar(ruta) as con:
        cur = con.execute(
            f"INSERT INTO citas ({','.join(CAMPOS)}) VALUES ({','.join('?' * len(CAMPOS))})",
            valores)
        return cur.lastrowid


def listar_citas(ruta):
    with _conectar(ruta) as con:
        return [dict(f) for f in con.execute("SELECT * FROM citas ORDER BY fecha, hora")]
