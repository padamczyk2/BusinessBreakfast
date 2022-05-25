<?php
session_start();

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$data = [
  'name'     => $_GET['firstname'] . " " . $_GET['lastname'],
  'email'    => $_GET['email'],
  'phone'    => $_GET['phone'],
  'position' => $_GET['position'],
];

$query = http_build_query($data);
$hash  = md5($data['email']);

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth   = true;
$mail->SMTPSecure = 'tls';
$mail->Host       = "localhost";
$mail->Port       = 25;
$mail->Username = "system-www@spotkanie-biznesowe.cloud";
$mail->Password = "Adu893rjhds-23";
$mail->CharSet    = "UTF-8";
$mail->SMTPDebug  = 1;
$mail->IsHTML(true);
$mail->setFrom('spotkaniebiznesowe@cloud.pl', 'Spotkanie biznesowe');
$mail->AddAddress($data['email']);
$mail->Subject = "Zaproszenie na śniadanie businessowe";
$mail->Body    = "
    <html>
    <head>
      <title>Zaproszenie na śniadanie businessowe</title>
    </head>
    <body>
      <p>Kliknij w poniższy link aby zarejestrować swój e-mail:</p>
      <a href='https://spotkanie-biznesowe.cloud/gateway.php?$query&id=$hash'>potwierdź e-mail</a>
    </body>
    </html>";

if ($mail->Send()) {
    http_response_code(200);
} else {
    http_response_code(409);
}

?>