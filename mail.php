<?php
session_start();

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$data = [
    'name' => $_GET['firstname'] . " " . $_GET['lastname'],
    'email' => $_GET['email'],
    'phone' => $_GET['phone'],
    'position' => $_GET['position'],
];

$query = http_build_query($data);
$hash = md5($data['email']);

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = "localhost";
$mail->Port = 25;
$mail->Username = "system-www@spotkanie-biznesowe.cloud";
$mail->Password = "Adu893rjhds-23";
$mail->CharSet = "UTF-8";
$mail->SMTPDebug = 1;
$mail->IsHTML(true);
$mail->setFrom('business.meeting@a1btl.pl', 'Spotkanie biznesowe');
$mail->AddAddress($data['email']);
$mail->Subject = "Zaproszenie na śniadanie businessowe";
$mail->Body = $twig->render('register.html', ['query' => $query, 'hash' => $hash]);


if ($mail->Send()) {
    http_response_code(200);
} else {
    http_response_code(409);
}

