"""API de VetConnect: recibe, valida y guarda solicitudes de cita."""
import os
import sqlite3
from flask import Flask, jsonify, request

from database import guardar_cita, init_db, listar_citas
from validators import validar_cita

FRONTEND = os.path.join(os.path.dirname(__file__), "..", "frontend")


def create_app(db_path=None):
    app = Flask(__name__, static_folder=FRONTEND, static_url_path="")
    app.config["DB_PATH"] = db_path or os.environ.get("VET_DB", "citas.db")
    init_db(app.config["DB_PATH"])

    @app.get("/")
    def index():
        return app.send_static_file("index.html")

    @app.post("/api/citas")
    def crear_cita():
        datos = request.get_json(silent=True) or {}
        errores = validar_cita(datos)
        if errores:
            return jsonify(errores=errores), 400
        try:
            cita_id = guardar_cita(app.config["DB_PATH"], datos)
        except sqlite3.Error:
            app.logger.exception("Error al guardar la cita")
            return jsonify(error="No se pudo guardar la cita."), 500
        return jsonify(id=cita_id), 201

    @app.get("/api/citas")
    def obtener_citas():
        return jsonify(listar_citas(app.config["DB_PATH"]))

    return app


if __name__ == "__main__":
    create_app().run(debug=True)
