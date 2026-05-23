<?php

declare(strict_types=1);

namespace Supabase\Client\Http;

use Psr\Http\Message\RequestInterface;

class Request
{
    private CurlClient $client;

    public function __construct(CurlClient $client)
    {
       // $this->request = $request;
    }

    public function send(): void
    {
        $this->client->sendRequest($this->request);
    }
}
