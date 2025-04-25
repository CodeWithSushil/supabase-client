<?php

require __dir__.'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$url = $_ENV['SB_URL'];
$url2 = $url."/rest/v1";
$key = $_ENV['SB_API_KEY'];


$url3 = $url."/rest/v1/users?select=*";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url3);
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

/*
use Fetch\Interfaces\Response as ResponseInterface;

$data = null;

async(fn () => fetch()
    ->baseUri("$url2")
    ->withQueryParameters(['select' => 1])
    ->withToken("Bearer $key")
    ->withHeaders([
        'apikey' => $key,
        'Content-Type' => 'application/json'
    ])
    ->get('/users'))
    ->then(fn (ResponseInterface $response)
    => $data = $response->json()) // Success handler
    ->catch(fn (Throwable $e) => $e->getMessage()); // Error handler

echo $data;
*/

use Fetch\Interfaces\Response as ResponseInterface;

$data = null;

// Asynchronously send a POST request using async/await syntax
async(fn () => fetch($url2, [
    'method' => 'GET',
    'headers' => ['Content-Type' => 'application/json'],
    'body' => json_encode(['key' => 'value']),
]))
    ->then(fn (ResponseInterface $response) => $data = $response->json())  // Success handler
    ->catch(fn (\Throwable $e) => print "Error: " . $e->getMessage());      // Error handler
