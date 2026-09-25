<?php

require __DIR__ . '/../models/GeoModel.php';
require __DIR__ . '/../models/AstroModel.php';

// Récupération données formulaire
$date = $_POST['date'] ?? null;
$heure = $_POST['heure'] ?? null;
$ville = $_POST['ville'] ?? null;

// Vérification formulaire
if (!$date || !$heure || !$ville) {
    echo "Formulaire incomplet";
    exit;
}

// Géolocalisation ville
$geo = new GeoModel();
$coords = $geo->getCoords($ville);

if (!$coords) {
    echo "Ville introuvable";
    exit;
}

$lat = $coords['lat'];
$lon = $coords['lon'];

// Appel API astrologique Python
$astro = new AstroModel();
$theme = $astro->getTheme($date, $heure, $lat, $lon);

// Affichage vue
require __DIR__ . '/../views/theme/result.php';
