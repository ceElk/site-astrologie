from flask import Flask, request, jsonify
import swisseph as swe
from datetime import datetime
import pytz

app = Flask(__name__)
swe.set_ephe_path('.')


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

        y, m, d  = map(int, date.split("-"))
        h, mi    = map(int, heure.split(":"))

        # ── Conversion heure locale Paris → UTC ──
        tz_paris = pytz.timezone("Europe/Paris")
        dt_local = tz_paris.localize(datetime(y, m, d, h, mi))
        dt_utc   = dt_local.astimezone(pytz.utc)

        h_utc = dt_utc.hour + dt_utc.minute / 60
        jd    = swe.julday(dt_utc.year, dt_utc.month, dt_utc.day, h_utc)

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
            planets[name] = swe.calc_ut(jd, pid)[0][0]

        houses, ascmc = swe.houses(jd, lat, lon, b'P')

        aspects = calc_aspects(planets)

        return jsonify({
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