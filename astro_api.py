from flask import Flask, request, jsonify
import swisseph as swe
from datetime import datetime
import pytz

#pour relancer python python3 astro_api.py dans le terminal
app = Flask(__name__)
swe.set_ephe_path('.')

AYANAMSAS = {
    "lahiri"        : swe.SIDM_LAHIRI,
    "fagan_bradley" : swe.SIDM_FAGAN_BRADLEY,
    "krishnamurti"  : swe.SIDM_KRISHNAMURTI,
    "raman"         : swe.SIDM_RAMAN,
}


def calc_aspects(planets):
    aspects = []
    names = list(planets.keys())

    for i in range(len(names)):
        for j in range(i+1, len(names)):

            p1 = planets[names[i]]
            p2 = planets[names[j]]

            diff = abs(p1 - p2)
            diff = min(diff, 360 - diff)

            orb = 6

            if abs(diff - 0) < orb:
                aspects.append(f"{names[i]} conjonction {names[j]}")
            elif abs(diff - 60) < orb:
                aspects.append(f"{names[i]} sextile {names[j]}")
            elif abs(diff - 90) < orb:
                aspects.append(f"{names[i]} carré {names[j]}")
            elif abs(diff - 120) < orb:
                aspects.append(f"{names[i]} trigone {names[j]}")
            elif abs(diff - 180) < orb:
                aspects.append(f"{names[i]} opposition {names[j]}")

    return aspects


@app.route('/theme')
def theme():

    try:
        date  = request.args.get("date")
        heure = request.args.get("heure")
        lat   = float(request.args.get("lat"))
        lon   = float(request.args.get("lon"))

        zodiac        = request.args.get("zodiac", "tropical")
        ayanamsa_name = request.args.get("ayanamsa", "lahiri")
        tz_name       = request.args.get("tz", "Europe/Paris")

        y, m, d = map(int, date.split("-"))
        h, mi   = map(int, heure.split(":"))

        # ── Conversion heure locale → UTC ──
        tz       = pytz.timezone(tz_name)
        dt_local = tz.localize(datetime(y, m, d, h, mi))
        dt_utc   = dt_local.astimezone(pytz.utc)

        h_utc = dt_utc.hour + dt_utc.minute / 60
        jd    = swe.julday(dt_utc.year, dt_utc.month, dt_utc.day, h_utc)

        # ── Choix du zodiaque ──
        flags = swe.FLG_SWIEPH
        ayanamsa_value = None

        if zodiac == "sidereal":
            if ayanamsa_name not in AYANAMSAS:
                return jsonify({"error": f"Ayanamsa inconnu : {ayanamsa_name}"}), 400
            swe.set_sid_mode(AYANAMSAS[ayanamsa_name])
            flags |= swe.FLG_SIDEREAL
            ayanamsa_value = swe.get_ayanamsa_ut(jd)
        elif zodiac != "tropical":
            return jsonify({"error": "zodiac doit valoir 'tropical' ou 'sidereal'"}), 400

        planets_id = {
            "sun"      : swe.SUN,
            "moon"     : swe.MOON,
            "mercury"  : swe.MERCURY,
            "venus"    : swe.VENUS,
            "mars"     : swe.MARS,
            "jupiter"  : swe.JUPITER,
            "saturn"   : swe.SATURN,
            "uranus"   : swe.URANUS,
            "neptune"  : swe.NEPTUNE,
            "pluto"    : swe.PLUTO,
            "true_node": swe.TRUE_NODE
        }

        planets = {}
        for name, pid in planets_id.items():
            planets[name] = swe.calc_ut(jd, pid, flags)[0][0]

        houses, ascmc = swe.houses_ex(jd, lat, lon, b'K', flags) #domiciliation koch(b'K)

        aspects = calc_aspects(planets)

        return jsonify({
            "zodiac"   : zodiac,
            "ayanamsa" : {"name": ayanamsa_name, "value": ayanamsa_value} if zodiac == "sidereal" else None,
            "planets"  : planets,
            "houses"   : list(houses),
            "ascendant": ascmc[0],
            "mc"       : ascmc[1],
            "aspects"  : aspects
        })

    except Exception as e:
        return jsonify({"error": str(e)}), 500


if __name__ == "__main__":
    app.run(port=5001, debug=True)