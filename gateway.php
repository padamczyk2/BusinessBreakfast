<?php
session_start();

require_once "vendor/autoload.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$url = 'https://api.getresponse.com/v3/contacts';

$header = ["Content-Type: application/json; charset=utf-8", "X-Auth-Token: api-key 5eaksrqtld9q406rcvn7z6gsk1257kfn"];

$data = [
    'name' => $_GET['name'],
    'email' => $_GET['email'],
    'campaign' => ['campaignId' => 'Q5B4Y']
];

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);


if (md5($data['email']) !== $_GET['id']) {
    echo $twig->render('register.html', ['message_bold' => 'Niestety coś poszło nie tak.', 'message' => 'Prosimy o ponowną rejestrację..']);
    die;
}

$data_string = json_encode($data);
$handle = curl_init($url);

curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($handle, CURLOPT_HEADER, true);
curl_setopt($handle, CURLOPT_HTTPHEADER, $header);
curl_setopt($handle, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($handle);
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_close($handle);


if ($httpCode === 202) {
    echo $twig->render('register.html', ['message_bold' => 'Dziękujemy', 'message' => 'Twój adres mailowy jest poprawny.']);
} else {
    echo $twig->render('register.html', ['message_bold' => 'Niestety coś poszło nie tak.', 'message' => 'Prosimy o ponowną rejestrację..']);
}
