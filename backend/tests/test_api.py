"""Pruebas de integración (API + base de datos) y uso de dobles de prueba (mock)."""
import sqlite3
from datetime import date, timedelta
from unittest.mock import patch
import pytest
from app import create_app
from database import guardar_cita, listar_citas

FUTURA = (date.today() + timedelta(days=7)).isoformat()
CITA = {"nombre": "Ana Ruiz", "correo": "ana@mail.com", "telefono": "3001234567",
        "canal": "correo", "mascota-nombre": "Toby", "especie": "perro", "edad": "3",
        "sexo": "macho", "servicio": "vacunacion", "fecha": FUTURA, "hora": "10:30"}


@pytest.fixture
def client(tmp_path):
    app = create_app(str(tmp_path / "test.db"))
    return app.test_client()


def test_crear_cita_devuelve_201_y_se_persiste(client):
    r = client.post("/api/citas", json=CITA)
    assert r.status_code == 201
    citas = client.get("/api/citas").get_json()
    assert len(citas) == 1 and citas[0]["mascota"] == "Toby"


def test_cita_invalida_devuelve_400_con_errores(client):
    r = client.post("/api/citas", json={**CITA, "correo": "mal"})
    assert r.status_code == 400 and "correo" in r.get_json()["errores"]
    assert client.get("/api/citas").get_json() == []


def test_cuerpo_que_no_es_json_devuelve_400(client):
    assert client.post("/api/citas", data="hola").status_code == 400


def test_error_de_base_de_datos_devuelve_500(client):
    with patch("app.guardar_cita", side_effect=sqlite3.Error("disco lleno")):
        r = client.post("/api/citas", json=CITA)
    assert r.status_code == 500 and "error" in r.get_json()


def test_pagina_principal_se_sirve(client):
    r = client.get("/")
    assert r.status_code == 200 and b"VetConnect" in r.data
    r.close()


def test_capa_de_datos_guardar_y_listar(tmp_path):
    ruta = str(tmp_path / "d.db")
    create_app(ruta)
    guardar_cita(ruta, CITA)
    assert listar_citas(ruta)[0]["servicio"] == "vacunacion"
