<?php

class AstroModel
{
    private string $apiUrl = "http://127.0.0.1:5001/theme";
    private ?array $texts = null;

    public function getTheme($date, $heure, $lat, $lon, $zodiac = 'tropical', $ayanamsa = 'lahiri')
    {
        $params = http_build_query([
            'date'     => $date,
            'heure'    => $heure,
            'lat'      => $lat,
            'lon'      => $lon,
            'zodiac'   => $zodiac,
            'ayanamsa' => $ayanamsa,
        ]);

        $json = @file_get_contents($this->apiUrl . "?" . $params);

        if ($json === false) {
            return ['error' => "L'API astrologique ne répond pas. Vérifie que astro_api.py est lancé."];
        }

        return json_decode($json, true);
    }

    public function getSign($deg)
    {
        $signs = [
            "Bélier", "Taureau", "Gémeaux", "Cancer",
            "Lion", "Vierge", "Balance", "Scorpion",
            "Sagittaire", "Capricorne", "Verseau", "Poissons"
        ];

        $deg = fmod($deg, 360);
        if ($deg < 0) {
            $deg += 360;
        }

        return $signs[(int) floor($deg / 30)];
    }

    public function interpret($planet, $sign)
    {
        if ($this->texts === null) {
            $this->texts = require __DIR__ . '/../data/interpretations.php';
        }

        return $this->texts[$planet][$sign] ?? "Interprétation à venir.";
    }
}