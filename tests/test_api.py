import pytest
from astro_api import app

# Paramètres de test : 20/02/1987 à 04h44 à Paris
PARAMS = {"date": "1987-02-20", "heure": "04:44", "lat": "48.85", "lon": "2.35"}


@pytest.fixture
def client():
    app.config["TESTING"] = True
    with app.test_client() as client:
        yield client


def test_theme_repond_200(client):
    reponse = client.get("/theme", query_string=PARAMS)
    assert reponse.status_code == 200


def test_theme_contient_les_planetes(client):
    data = client.get("/theme", query_string=PARAMS).get_json()
    for planete in ["sun", "moon", "mercury", "venus", "mars", "jupiter", "saturn"]:
        assert planete in data["planets"]


def test_theme_a_douze_maisons(client):
    data = client.get("/theme", query_string=PARAMS).get_json()
    assert len(data["houses"]) == 12


def test_position_du_soleil(client):
    # Le 20/02/1987, le Soleil est à environ 331° (Poissons, zodiaque tropical)
    data = client.get("/theme", query_string=PARAMS).get_json()
    assert 100 < data["planets"]["sun"] < 101


def test_mode_sideral_repond(client):
    params = {**PARAMS, "zodiac": "sidereal", "ayanamsa": "lahiri"}
    reponse = client.get("/theme", query_string=params)
    assert reponse.status_code == 200
