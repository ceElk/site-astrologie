<?php
// Ajoute temporairement ceci pour déboguer

function getSign($deg)
{
    $signs = [
        "Bélier","Taureau","Gémeaux","Cancer",
        "Lion","Vierge","Balance","Scorpion",
        "Sagittaire","Capricorne","Verseau","Poissons"
    ];

    $deg = fmod($deg, 360);
    if ($deg < 0) {
        $deg += 360;
    }

    return $signs[(int) floor($deg / 30)];
}

function translatePlanet($p)
{
    return [
        "sun"       => "☉ Soleil",
        "moon"      => "☽ Lune",
        "mercury"   => "☿ Mercure",
        "venus"     => "♀ Vénus",
        "mars"      => "♂ Mars",
        "jupiter"   => "♃ Jupiter",
        "saturn"    => "♄ Saturne",
        "uranus"    => "♅ Uranus",
        "neptune"   => "♆ Neptune",
        "pluto"     => "♇ Pluton",
        "true_node" => "☊ Nœud Nord"
    ][$p] ?? $p;
}

function planetSymbol($p)
{
    return [
        "sun"       => "☉",
        "moon"      => "☽",
        "mercury"   => "☿",
        "venus"     => "♀",
        "mars"      => "♂",
        "jupiter"   => "♃",
        "saturn"    => "♄",
        "uranus"    => "♅",
        "neptune"   => "♆",
        "pluto"     => "♇",
        "true_node" => "☊"
    ][$p] ?? strtoupper(substr($p,0,2));
}

function planetColor($p)
{
    return [
        "sun"       => "#ff9900",
        "moon"      => "#ccccff",
        "mercury"   => "#cc44ff",
        "venus"     => "#ff66aa",
        "mars"      => "#ff3300",
        "jupiter"   => "#44aaff",
        "saturn"    => "#aaaaaa",
        "uranus"    => "#00ffcc",
        "neptune"   => "#4466ff",
        "pluto"     => "#884400",
        "true_node" => "#ffff00"
    ][$p] ?? "#ffffff";
}

function aspectColor($asp)
{
    return [
        "conjonction" => "#ff4444",
        "conjunction" => "#ff4444",
        "opposition"  => "#ff4444",
        "carré"       => "#ff4444",
        "square"      => "#ff4444",
        "trigone"     => "#4488ff",
        "trine"       => "#4488ff",
        "sextile"     => "#4488ff",
    ][$asp] ?? "#888888";
}

function aspectStyle($asp)
{
    return in_array($asp, ["trigone", "trine", "sextile"])
        ? ""
        : "stroke-dasharray='5,3'";
}

$planets   = $theme['planets'] ?? [];
$houses    = $theme['houses'] ?? [];
$ascendant = $theme['ascendant'] ?? 0;
$mc        = $theme['mc'] ?? 0;
echo "<!-- ascendant=$ascendant | mc=$mc -->"; // ← ajoute ici
$aspects   = $theme['aspects'] ?? [];

?>


<h2>Informations reçues :</h2>
<p>Date : <?= htmlspecialchars($date) ?></p>
<p>Heure : <?= htmlspecialchars($heure) ?></p>
<p>Ville : <?= htmlspecialchars($ville) ?></p>
<p>
    Zodiaque <?= ($theme['zodiac'] ?? 'tropical') === 'sidereal' ? 'sidéral' : 'tropical' ?>
    <?php if (($theme['zodiac'] ?? '') === 'sidereal' && !empty($theme['ayanamsa'])): ?>
        (<?= htmlspecialchars($theme['ayanamsa']['name']) ?> :
        <?= number_format($theme['ayanamsa']['value'], 2, ',', '') ?>°)
    <?php endif; ?>
</p>

<hr>
<h2>Ascendant : <?= round($ascendant,2) ?>°</h2>
<h3>MC : <?= round($mc,2) ?>°</h3>
<hr>

<h2>Roue astrologique</h2>

<svg width="700" height="700" viewBox="0 0 700 700"
     style="background:#06142b;border:1px solid #333;display:block;margin:auto">

<?php
$cx      = 350;
$cy      = 350;
$r3      = 280;
$r2      = 250;
$r1      = 195;
$rInner  = 130;
$rCenter = 80;

/* ── Cercles ── */
echo "<circle cx='$cx' cy='$cy' r='$r3' fill='#0a1f3a' stroke='white' stroke-width='2'/>";
echo "<circle cx='$cx' cy='$cy' r='$r2' fill='#06142b' stroke='white' stroke-width='1'/>";
echo "<circle cx='$cx' cy='$cy' r='$r1' fill='#06142b' stroke='white' stroke-width='1' opacity='0.7'/>";
echo "<circle cx='$cx' cy='$cy' r='$rInner' fill='#06142b' stroke='white' stroke-width='1' opacity='0.4'/>";
echo "<circle cx='$cx' cy='$cy' r='$rCenter' fill='#040d1e' stroke='white' stroke-width='0.5' opacity='0.3'/>";

/* ── Graduations ── */
for ($d = 0; $d < 360; $d++) {
    $angle     = deg2rad(-($d - $ascendant) + 180);
    $tickInner = ($d % 10 === 0) ? $r3 - 12 : (($d % 5 === 0) ? $r3 - 8 : $r3 - 4);
    $x1 = $cx + cos($angle) * $tickInner;
    $y1 = $cy + sin($angle) * $tickInner;
    $x2 = $cx + cos($angle) * $r3;
    $y2 = $cy + sin($angle) * $r3;
    $sw = ($d % 10 === 0) ? "1.2" : "0.5";
    echo "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' stroke='white' stroke-width='$sw' opacity='0.6'/>";
}

/* ── Séparateurs des 12 signes ── */
for ($i = 0; $i < 12; $i++) {
    $angle = deg2rad(-($i * 30 - $ascendant) + 180);
    $x1 = $cx + cos($angle) * $r2;
    $y1 = $cy + sin($angle) * $r2;
    $x2 = $cx + cos($angle) * $r3;
    $y2 = $cy + sin($angle) * $r3;
    echo "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' stroke='white' stroke-width='1'/>";
}

/* ── Signes zodiacaux ── */
$signs      = ["♈","♉","♊","♋","♌","♍","♎","♏","♐","♑","♒","♓"];
$signColors = ["#ff4444","#884400","#ffaa00","#00aaff",
               "#ff4444","#884400","#ffaa00","#00aaff",
               "#ff4444","#884400","#ffaa00","#00aaff"];
$rSign = ($r2 + $r3) / 2;

for ($i = 0; $i < 12; $i++) {
    $angle = deg2rad(-(($i * 30 + 15) - $ascendant) + 180);
    $x = $cx + cos($angle) * $rSign;
    $y = $cy + sin($angle) * $rSign;
    echo "<text x='$x' y='$y'
                fill='{$signColors[$i]}' font-size='20'
                text-anchor='middle' dominant-baseline='middle'
                font-family='serif'>{$signs[$i]}</text>";
}

/* ── Lignes des maisons ── */
foreach ($houses as $houseDeg) {
    $angle = deg2rad(-($houseDeg - $ascendant) + 180);
    $x1 = $cx + cos($angle) * $rInner;
    $y1 = $cy + sin($angle) * $rInner;
    $x2 = $cx + cos($angle) * $r1;
    $y2 = $cy + sin($angle) * $r1;
    echo "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' stroke='white' stroke-width='0.8'/>";
}

/* ── Axes AC/DC et MC/FC ── */
// AC = cuspide maison 1 = $houses[0]
// MC = cuspide maison 10 = $houses[9]
$angleAC = deg2rad(-($houses[0] - $ascendant) + 180);
$angleMC = deg2rad(-($houses[9] - $ascendant) + 180);

echo "<line x1='".($cx + cos($angleAC)*$r3)."' y1='".($cy + sin($angleAC)*$r3)."'
            x2='".($cx - cos($angleAC)*$r3)."' y2='".($cy - sin($angleAC)*$r3)."'
            stroke='white' stroke-width='1.5'/>";

echo "<line x1='".($cx + cos($angleMC)*$r3)."' y1='".($cy + sin($angleMC)*$r3)."'
            x2='".($cx - cos($angleMC)*$r3)."' y2='".($cy - sin($angleMC)*$r3)."'
            stroke='white' stroke-width='1.5'/>";

/* ── Triangles ── */
function drawTriangle($cx, $cy, $angle, $r) {
    $tip = ['x' => $cx + cos($angle)*$r,       'y' => $cy + sin($angle)*$r];
    $b1  = ['x' => $cx + cos($angle)*($r-14) + cos($angle+M_PI/2)*7,
            'y' => $cy + sin($angle)*($r-14) + sin($angle+M_PI/2)*7];
    $b2  = ['x' => $cx + cos($angle)*($r-14) + cos($angle-M_PI/2)*7,
            'y' => $cy + sin($angle)*($r-14) + sin($angle-M_PI/2)*7];
    echo "<polygon points='{$tip['x']},{$tip['y']} {$b1['x']},{$b1['y']} {$b2['x']},{$b2['y']}'
                  fill='black' stroke='white' stroke-width='1'/>";
}

drawTriangle($cx, $cy, $angleAC,        $r1);
drawTriangle($cx, $cy, $angleAC+M_PI,   $r1);
drawTriangle($cx, $cy, $angleMC,        $r1);
drawTriangle($cx, $cy, $angleMC+M_PI,   $r1);

/* ── Labels AC et MC ── */
echo "<text x='".($cx + cos($angleAC)*($r1+25))."'
            y='".($cy + sin($angleAC)*($r1+25)+5)."'
            fill='white' font-size='14' font-weight='bold'
            text-anchor='middle'>AC</text>";

echo "<text x='".($cx + cos($angleMC)*($r1+25))."'
            y='".($cy + sin($angleMC)*($r1+25)+5)."'
            fill='white' font-size='14' font-weight='bold'
            text-anchor='middle'>MC</text>";

/* ── Numéros de maisons ── */
foreach ($houses as $i => $houseDeg) {
    $nextDeg = $houses[($i+1)%12];
    $a1      = -($houseDeg - $ascendant) + 180;
    $a2      = -($nextDeg  - $ascendant) + 180;
    $diff    = $a2 - $a1;
    if ($diff >  180) $diff -= 360;
    if ($diff < -180) $diff += 360;
    $aMid = deg2rad($a1 + $diff / 2);

    $rNum = ($rInner + $rCenter) / 2;
    $xNum = $cx + cos($aMid) * $rNum;
    $yNum = $cy + sin($aMid) * $rNum;

    $numero = $i + 1;

    echo "<text x='$xNum' y='$yNum'
                fill='#aaaaee' font-size='12'
                text-anchor='middle' dominant-baseline='middle'>
                $numero
          </text>";
}

/* ── Lignes d'aspects ── */
foreach ($aspects as $asp) {
    $parts = explode(" ", $asp);
    if (count($parts) < 3) continue;
    [$p1, $aspectType, $p2] = $parts;
    if (!isset($planets[$p1]) || !isset($planets[$p2])) continue;

    $angle1 = deg2rad(-($planets[$p1] - $ascendant) + 180);
    $angle2 = deg2rad(-($planets[$p2] - $ascendant) + 180);

    $x1 = $cx + cos($angle1) * $rCenter;
    $y1 = $cy + sin($angle1) * $rCenter;
    $x2 = $cx + cos($angle2) * $rCenter;
    $y2 = $cy + sin($angle2) * $rCenter;

    $color = aspectColor($aspectType);
    $style = aspectStyle($aspectType);

    echo "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2'
                stroke='$color' stroke-width='1' opacity='0.8' $style/>";
}

/* ── Planètes ── */
$rPlanet = ($rInner + $r1) / 2;

foreach ($planets as $planet => $deg) {
    $angle  = deg2rad(-($deg - $ascendant) + 180);
    $color  = planetColor($planet);
    $symbol = planetSymbol($planet);

    $x = $cx + cos($angle) * $rPlanet;
    $y = $cy + sin($angle) * $rPlanet;

    $xInner = $cx + cos($angle) * $rInner;
    $yInner = $cy + sin($angle) * $rInner;
    echo "<line x1='$xInner' y1='$yInner' x2='$x' y2='$y'
                stroke='$color' stroke-width='0.5' opacity='0.5'/>";

    echo "<text x='$x' y='$y'
                fill='$color' font-size='18'
                text-anchor='middle' dominant-baseline='middle'
                font-family='serif'>$symbol</text>";
}
?>

</svg>

<hr>
<h2>Aspects planétaires</h2>

<?php if (!empty($aspects)): ?>
<ul>
<?php foreach ($aspects as $asp):
    $parts = explode(" ", $asp);
    if (count($parts) < 3) continue;
    [$p1, $aspect, $p2] = $parts;
    $sign1 = getSign($planets[$p1] ?? 0);
    $sign2 = getSign($planets[$p2] ?? 0);
?>
<li>
    <?= translatePlanet($p1) ?> en <strong><?= $sign1 ?></strong>
    <?= htmlspecialchars($aspect) ?>
    <?= translatePlanet($p2) ?> en <strong><?= $sign2 ?></strong>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>Aucun aspect détecté.</p>
<?php endif; ?>

<hr>
<h2>Positions astrologiques</h2>
<ul>
<?php foreach ($planets as $planet => $deg): ?>
<li>
    <?= translatePlanet($planet) ?>
    en <strong><?= getSign($deg) ?></strong>
    (<?= round($deg,1) ?>°)
</li>
<?php endforeach; ?>
</ul>

<h2>Interprétation rapide</h2>
<div class="interp">
<?php foreach ($planets as $planet => $deg):
    $sign = getSign($deg);
?>
<p>
    <?= translatePlanet($planet) ?>
    en <strong><?= $sign ?></strong> :
    <?= htmlspecialchars($astro->interpret($planet, $sign)) ?>
</p>
<?php endforeach; ?>
</div>
<!-- Dans le <head> de ta page -->
<style>
    body {
        background: #020b18;
        color: #e0e0ff;
        font-family: 'Georgia', serif;
        margin: 0;
        padding: 20px;
    }

    h1, h2, h3 {
        color: #c8a96e;
        letter-spacing: 2px;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(200,169,110,0.3);
        padding-bottom: 8px;
    }

    /* Carte d'infos */
    .info-carte {
        background: linear-gradient(135deg, #0a1f3a, #06142b);
        border: 1px solid rgba(200,169,110,0.4);
        border-radius: 12px;
        padding: 20px 30px;
        margin: 20px auto;
        max-width: 700px;
        display: flex;
        gap: 40px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .info-carte p {
        margin: 5px 0;
        color: #aaaacc;
        font-size: 14px;
    }

    .info-carte span {
        color: #c8a96e;
        font-weight: bold;
    }

    /* Ascendant / MC */
    .asc-mc {
        background: linear-gradient(135deg, #0a1f3a, #06142b);
        border: 1px solid rgba(100,150,255,0.3);
        border-radius: 12px;
        padding: 15px 30px;
        margin: 10px auto;
        max-width: 700px;
        display: flex;
        gap: 40px;
        justify-content: center;
    }

    .asc-mc h2, .asc-mc h3 {
        margin: 0;
        border: none;
        font-size: 16px;
        color: #88aaff;
    }

    /* Roue centrée */
    .roue-wrapper {
        display: flex;
        justify-content: center;
        margin: 30px auto;
    }

    /* Aspects */
    .aspects-liste {
        max-width: 700px;
        margin: 0 auto;
        list-style: none;
        padding: 0;
    }

    .aspects-liste li {
        background: rgba(10,31,58,0.6);
        border-left: 3px solid #4488ff;
        border-radius: 6px;
        padding: 8px 15px;
        margin: 6px 0;
        font-size: 14px;
        color: #ccccee;
    }

    .aspects-liste li.rouge {
        border-left-color: #ff4444;
    }

    /* Positions */
    .positions-liste {
        max-width: 700px;
        margin: 0 auto;
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .positions-liste li {
        background: rgba(10,31,58,0.6);
        border: 1px solid rgba(100,100,200,0.2);
        border-radius: 6px;
        padding: 8px 15px;
        font-size: 14px;
        color: #ccccee;
    }

    /* Interprétation */
    .interp p {
        background: rgba(10,31,58,0.4);
        border-radius: 8px;
        padding: 10px 15px;
        margin: 6px auto;
        max-width: 700px;
        font-size: 14px;
        color: #aaaacc;
        border-left: 3px solid rgba(200,169,110,0.5);
    }

    hr {
        border: none;
        border-top: 1px solid rgba(200,169,110,0.2);
        margin: 30px auto;
        max-width: 700px;
    }
</style>