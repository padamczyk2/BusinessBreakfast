<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$url = 'https://api.getresponse.com/v3/contacts';

$header = ["Content-Type: application/json; charset=utf-8", "X-Auth-Token: api-key 5eaksrqtld9q406rcvn7z6gsk1257kfn"];

$data = [
  'name'     => $_GET['name'],
  'email'    => $_GET['email'],
  'campaign' => ['campaignId' => 'Q5B4Y']
];

if (md5($data['email']) !== $_GET['id']) {
    echo "<p>Ups, coś poszło nie tak - byc może Twój e-mail już został zarejestrowany wcześniej</p>";
    die;
}

$data_string = json_encode($data);
$handle      = curl_init($url);

curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($handle, CURLOPT_HEADER, true);
curl_setopt($handle, CURLOPT_HTTPHEADER, $header);
curl_setopt($handle, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$output   = curl_exec($handle);
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_close($handle);

if ($httpCode === 202) {
    echo "<p>Dziękujemy serdecznie, Twój e-mail " . $data['email'] . " został zarejestrowany</p>>";
} else {
    echo "<p>Ups, coś poszło nie tak - byc może Twój e-mail już został zarejestrowany wcześniej</p>";
}
