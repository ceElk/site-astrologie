<?php

class GeoModel
{
    public function getCoords($ville)
    {
        $url = "https://nominatim.openstreetmap.org/search?q="
             . urlencode($ville)
             . "&format=json&limit=1";

        // CONTEXTE HTTP avec User-Agent obligatoire
        $options = [
            "http" => [
                "header" => "User-Agent: AstroSite/1.0\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $json = file_get_contents($url, false, $context);

        if (!$json) {
            return null;
        }

        $data = json_decode($json, true);

        if (!empty($data[0])) {
            return [
                'lat' => $data[0]['lat'],
                'lon' => $data[0]['lon']
            ];
        }

        return null;
    }
}
