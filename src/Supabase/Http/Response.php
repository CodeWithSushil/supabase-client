<?php

declare(strict_types=1);

namespace Supabase\Client\Http;

class Response
{
    public function __construct(
        protected string $body,
        protected int $status,
        protected array $headers = []
    ) {}

    public function json(): array|null
    {
        return json_decode($this->body, true);
    }
}
