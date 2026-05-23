<?php

declare(strict_types=1);

namespace Supabase\Client\Http;

use JsonException;
use RuntimeException;

class CurlClient
{
    public function send(
        string $method,
        string $url,
        array $headers = [],
        array|string|null $body = null
    ): Response {
        $curl = curl_init();

        if ($curl === false) {
            throw new RuntimeException('Unable to initialize cURL.');
        }

        $formattedHeaders = [];

        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "{$key}: {$value}";
        }

        $payload = null;

        if ($body !== null) {
            $payload = is_array($body)
                ? json_encode($body, JSON_THROW_ON_ERROR)
                : $body;
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,

            CURLOPT_CUSTOMREQUEST => strtoupper($method),

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_HTTPHEADER => $formattedHeaders,

            CURLOPT_POSTFIELDS => $payload,

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,

            CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,

            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTPS,

            CURLOPT_FOLLOWLOCATION => false,

            /*
            |--------------------------------------------------------------------------
            | Performance
            |--------------------------------------------------------------------------
            */

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2TLS,

            CURLOPT_TCP_KEEPALIVE => 1,

            CURLOPT_TCP_KEEPIDLE => 120,

            CURLOPT_TCP_KEEPINTVL => 60,

            CURLOPT_ENCODING => '',

            CURLOPT_FORBID_REUSE => false,

            CURLOPT_FRESH_CONNECT => false,

            /*
            |--------------------------------------------------------------------------
            | Timeouts
            |--------------------------------------------------------------------------
            */

            CURLOPT_CONNECTTIMEOUT => 10,

            CURLOPT_TIMEOUT => 30,

            /*
            |--------------------------------------------------------------------------
            | Safety
            |--------------------------------------------------------------------------
            */

            CURLOPT_MAXREDIRS => 0,

            CURLOPT_FAILONERROR => false,

            CURLOPT_HEADER => false,
        ]);

        $responseBody = curl_exec($curl);

        if ($responseBody === false) {
            $error = curl_error($curl);

            curl_close($curl);

            throw new RuntimeException(
                message: $error
            );
        }

        $statusCode = curl_getinfo(
            $curl,
            CURLINFO_HTTP_CODE
        );

        curl_close($curl);

        return new Response(
            body: $responseBody,
            status: $statusCode
        );
    }

    protected function throwHttpException(
        int $status,
        string $body
    ): never {
        match ($status) {
            400 => throw new BadRequestException(
                'Bad request.',
                400
            ),

            401 => throw new InvalidApiKeyException(
                'Invalid API key.',
                401
            ),

            403 => throw new InvalidServiceRoleException(
                'Invalid service role key.',
                403
            ),

            404 => throw new NotFoundException(
                'Resource not found.',
                404
            ),

            500, 502, 503, 504 => throw new ServerErrorException(
                'Supabase server error.',
                $status
            ),

            default => throw new UnauthorizedException(
                message: $body ?: 'HTTP request failed.',
                status: $status
            ),
        };
    }
}
