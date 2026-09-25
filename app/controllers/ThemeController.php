<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date  = $_POST['date']  ?? '';
    $heure = $_POST['heure'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $lat   = $_POST['lat']   ?? '';
    $lon   = $_POST['lon']   ?? '';

    $url = "http://localhost:5000/theme?"
         . "date=" . urlencode($date)
         . "&heure=" . urlencode($heure)
         . "&lat=" . urlencode($lat)
         . "&lon=" . urlencode($lon);

    $response = file_get_contents($url);
    $theme    = json_decode($response, true);

    if (!$theme || isset($theme['error'])) {
        echo "<p style='color:red'>Erreur API : " . htmlspecialchars($theme['error'] ?? 'inconnue') . "</p>";
        exit;
    }

    require "../app/views/theme/result.php";

} else {

    require "../app/views/theme/form.php";

}