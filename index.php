<?php

require __dir__.'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$url = $_ENV['SB_URL'];
$key = $_ENV['SB_API_KEY'];

$url2 = $url."/rest/v1/users?select=*";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$header = [
    'Content-Type: application/json',
    "apikey: $key",
    "Authorization: Bearer $key",
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

$result = curl_exec($ch);
$data = json_decode($result, true);

print('<pre>');
print_r($data);
print('</pre>');
