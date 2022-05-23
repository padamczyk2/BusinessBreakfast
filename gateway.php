<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$url = 'https://api.getresponse.com/v3/contacts';

$header = ["Content-Type: application/json; charset=utf-8", "X-Auth-Token: api-key 2sswzzjlkosu3r63jxo043hefie1y9z2"];

$data = [
    'name' => $_GET['firstname'] . " " . $_GET['lastname'],
    'email' => $_GET['email'],
    'campaign' => ['campaignId' => 'ZRgUy']
];

$data_string = json_encode($data);
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

$output = curl_exec($ch);

echo $output;

?>