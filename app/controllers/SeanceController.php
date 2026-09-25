<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom       = $_POST['nom']       ?? '';
    $email     = $_POST['email']     ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $seance    = $_POST['seance']    ?? '';
    $objet     = $_POST['objet']     ?? '';
    $message   = $_POST['message']   ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cecilia.elkrieff@gmail.com';
        $mail->Password   = 'belm ikgj jotu ttxv'; // ← 16 caractères générés par Google
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('cecilia.elkrieff@gmail.com', 'AstroThème');
        $mail->addAddress('cecilia.elkrieff@gmail.com');
        $mail->addReplyTo($email, $nom);

        $mail->Subject = "✦ Demande de séance — $objet";
        $mail->Body    = "
Nom : $nom
Email : $email
Téléphone : $telephone
Type de séance : $seance
Objet : $objet

Message :
$message
        ";

        $mail->send();
        $succes = true;

    } catch (Exception $e) {
        $erreur = $mail->ErrorInfo;
    }
}

require '../app/views/seanceastro.php';