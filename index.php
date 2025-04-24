<?php

require __dir__.'/vendor/autoload.php';
use Supabase\Client;

$client = Client::connect();
$client->setURL('https://supabase.co');
$client->setApiKey('fsvbg');
