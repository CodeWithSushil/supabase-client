<?php

declare(strict_types=1);

namespace Supabase\Client\Validation;

use Supabase\Client\Exceptions\InvalidProjectUrlException;

class ProjectUrlValidator
{
    public static function validate(
        string $url
    ): void {
        if (!filter_var(
            $url,
            FILTER_VALIDATE_URL
        )) {
            throw new InvalidProjectUrlException(
                'Invalid project URL.'
            );
        }

        $parts = parse_url($url);

        /*
        |--------------------------------------------------------------------------
        | HTTPS Required
        |--------------------------------------------------------------------------
        */

        if (
            !isset($parts['scheme']) ||
            strtolower($parts['scheme']) !== 'https'
        ) {
            throw new InvalidProjectUrlException(
                'Supabase URL must use HTTPS.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Valid Supabase Domain
        |--------------------------------------------------------------------------
        */

        if (
            !isset($parts['host']) ||
            !str_ends_with(
                $parts['host'],
                '.supabase.co'
            )
        ) {
            throw new InvalidProjectUrlException(
                'Invalid Supabase project domain.'
            );
        }
    }
}
