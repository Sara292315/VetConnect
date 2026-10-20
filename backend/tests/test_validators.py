"""Pruebas unitarias de caja negra (entradas/salidas) y caja blanca (cada rama)."""
from datetime import date
import pytest
from validators import (validar_correo, validar_telefono, validar_fecha,
                        validar_horario, validar_edad, validar_cita)

HOY = date(2026, 10, 20)
VALIDA = {"nombre": "Ana Ruiz", "correo": "ana@mail.com", "telefono": "300 123 4567",
          "canal": "correo", "mascota-nombre": "Toby", "especie": "perro", "edad": "3",
          "servicio": "vacunacion", "fecha": "2026-10-25", "hora": "10:30"}


@pytest.mark.parametrize("v,esperado", [("a@b.co", True), (" a@b.co ", True),
    ("sin-arroba", False), ("a@b", False), ("", False), (None, False)])
def test_correo(v, esperado):
    assert validar_correo(v) is esperado


@pytest.mark.parametrize("v,esperado", [("3001234567", True), ("+57 300 1234", True),
    ("123", False), ("abc1234567", False), (None, False)])
def test_telefono(v, esperado):
    assert validar_telefono(v) is esperado


@pytest.mark.parametrize("v,esperado", [("2026-10-20", True), ("2026-12-01", True),
    ("2026-10-19", False), ("20/10/2026", False), (None, False)])
def test_fecha_valores_limite(v, esperado):
    assert validar_fecha(v, HOY) is esperado


def test_fecha_usa_hoy_real_por_defecto():
    assert validar_fecha("2000-01-01") is False


@pytest.mark.parametrize("v,esperado", [("08:00", True), ("18:00", True),
    ("07:59", False), ("18:01", False), ("25:00", False), (None, False)])
def test_horario_valores_limite(v, esperado):
    assert validar_horario(v) is esperado


@pytest.mark.parametrize("v,esperado", [("0", True), (20, True), ("21", False),
    ("-1", False), ("x", False), (None, False)])
def test_edad(v, esperado):
    assert validar_edad(v) is esperado


def test_cita_valida_no_tiene_errores():
    assert validar_cita(VALIDA, HOY) == {}


@pytest.mark.parametrize("campo,valor", [("nombre", "Al"), ("correo", "x"),
    ("telefono", "1"), ("canal", "paloma"), ("mascota-nombre", " "),
    ("especie", "dragon"), ("edad", "99"), ("servicio", ""),
    ("fecha", "2020-01-01"), ("hora", "23:00")])
def test_cada_campo_invalido_se_reporta(campo, valor):
    errores = validar_cita({**VALIDA, campo: valor}, HOY)
    assert list(errores) == [campo]


def test_cita_vacia_reporta_todos_los_campos():
    assert len(validar_cita({}, HOY)) == 10
