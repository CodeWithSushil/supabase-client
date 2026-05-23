<?php

declare(strict_types=1);

namespace Supabase\Client\Http;

use Psr\Http\Message\ResponseInterface;
use JsonException;

class Response
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function json(): mixed
    {
        $content = (string) $this->response->getBody();

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }
}
