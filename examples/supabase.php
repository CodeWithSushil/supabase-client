<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use Supabase\Client\Supabase;

$config = [
    'url' => 'https://tkfppmaqexgalcutakdm.supabase.co',
    'apikey' => 'CJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRrZnBwbWFxZXhnYWxjdXRha2RtIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc4OTcwMzI1OSwiZXhwIjoyMTA1Mjc5MjU5fQ.wMt2cTYMdVrx2NTnqzFfM1xdXZwSMyqx3NEMzc984K8'
];

$client = new Supabase($config);

var_dump($client);
