<?php

require __DIR__ . '/../models/GeoModel.php';
require __DIR__ . '/../models/AstroModel.php';

// Récupération données formulaire
$date  = $_POST['date']  ?? null;
$heure = $_POST['heure'] ?? null;
$ville = $_POST['ville'] ?? null;

// Zodiaque et ayanamsa (seules les valeurs prévues sont acceptées)
$zodiac = in_array($_POST['zodiac'] ?? '', ['tropical', 'sidereal'], true)
    ? $_POST['zodiac']
    : 'tropical';

$ayanamsa = in_array($_POST['ayanamsa'] ?? '', ['lahiri', 'fagan_bradley', 'krishnamurti', 'raman'], true)
    ? $_POST['ayanamsa']
    : 'lahiri';

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
$theme = $astro->getTheme($date, $heure, $lat, $lon, $zodiac, $ayanamsa);

// Erreur API
if (!$theme || isset($theme['error'])) {
    echo "<p>Erreur : " . htmlspecialchars($theme['error'] ?? 'réponse invalide de l\'API') . "</p>";
    exit;
}

// Affichage vue
require __DIR__ . '/../views/theme/result.php';