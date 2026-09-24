<?php

declare(strict_types=1);

namespace Supabase;

use RuntimeException;

class Supabase
{
    public function __construct(
        private array $config
    ) {
        if(!empty($this->config['url']))
        {
            $url = rtrim($this->config['url'], '/');
            $url = parse_url($url);
        } else {
            throw new RuntimeException('Supabase URL is required.');
        }

        if(!empty($this->config['apikey']))
        {

        } else {
            throw new RuntimeException('Supabase API key is required.');
        }
    }
}
