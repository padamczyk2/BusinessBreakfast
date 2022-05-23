<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$data = [
  'name'     => $_GET['firstname'] . " " . $_GET['lastname'],
  'email'    => $_GET['email'],
  'phone'    => $_GET['phone'],
  'position' => $_GET['position'],
];

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'To: '.$data['name'].' <'. $data['email'].'>';
$headers[] = 'From: Spotkanie biznesowe <spotkanie-biznesowe@cloud>';

$to      = $data['email'];
$subject = 'Zaproszenie na śniadanie businessowe';
$query = http_build_query($data);
$hash = md5($data['email']);

$message = "
<html>
<head>
  <title>Zaproszenie na śniadanie businessowe</title>
</head>
<body>
  <p>Kliknij w poniższy link aby zarejestrować swój e-mail:</p>
  <a href='https://spotkanie-biznesowe.cloud/gateway.php?$query&id=$hash'>potwierdź e-mail</a>
</body>
</html>";


if (mail($to, $subject, $message,  implode("\r\n", $headers))) {
    http_response_code(200);
} else {
    http_response_code(409);
}

?>