<?php

declare(strict_types=1);

namespace Supabase\Client\Validation;

use Supabase\Client\Exceptions\InvalidProjectUrlException;

class ProjectUrlValidator
{
    public static function validate(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidProjectUrlException(
                'Invalid Supabase project URL.'
            );
        }

        if (!str_contains($url, '.supabase.co')) {
            throw new InvalidProjectUrlException(
                'Invalid Supabase domain.'
            );
        }
    }
}
