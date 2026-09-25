<?php
$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Astro Theme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background:#020b18;color:#e0e0ff">

<!-- NAVBAR sur toutes les pages -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#020b18;border-bottom:1px solid rgba(200,169,110,0.3)">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="index.php" style="color:#c8a96e;font-family:Georgia,serif;letter-spacing:2px">
            ✦ Karma & Love
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color:#e0e0ff">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=theme" style="color:#e0e0ff">Générer mon thème</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=seance" style="color:#e0e0ff">Séance astrologique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=apropos" style="color:#e0e0ff">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=contact" style="color:#e0e0ff">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php
switch ($page) {
    case 'theme':
        require "../app/controllers/ThemeController.php";
        break;
    case 'theme-result':
        require "../app/controllers/ThemeResultController.php";
        break;
    case 'seance':
        require "../app/controllers/SeanceController.php";
        break;
    case 'apropos':
        require "../app/views/apropos.php";
        break;
    case 'contact':
        require "../app/views/contact.php";
        break;
    default:
        require "../app/views/home.php";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>