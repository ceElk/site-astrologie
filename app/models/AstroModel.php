<?php

class AstroModel
{
    public function getTheme($date, $heure, $lat, $lon)
    {
        $url = "http://127.0.0.1:5001/theme"
             . "?date=$date"
             . "&heure=$heure"
             . "&lat=$lat"
             . "&lon=$lon";

        $json = file_get_contents($url);

        return json_decode($json, true);
    }
    public function getSign($deg)
{
    $signs = [
        "Bélier", "Taureau", "Gémeaux", "Cancer",
        "Lion", "Vierge", "Balance", "Scorpion",
        "Sagittaire", "Capricorne", "Verseau", "Poissons"
    ];

    return $signs[floor($deg / 30)];
}
public function interpret($planet, $sign)
{
    $texts = [

        "sun" => [
            "Poissons" => "Sensibilité, intuition forte, spiritualité.",
            "Bélier" => "Énergie, initiative, leadership.",
            "Taureau" => "Stabilité, sensualité, attachement au concret."
        ],

        "moon" => [
            "Scorpion" => "Émotions intenses, profondeur psychique.",
            "Cancer" => "Grande sensibilité familiale.",
        ]
    ];

    return $texts[$planet][$sign] ?? "Interprétation à venir.";
}

}
