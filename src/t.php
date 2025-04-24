<?php

use Fetch\Interfaces\Response as ResponseInterface;

$data = null;

async(fn () => fetch()
    ->baseUri('https://example.com')
    ->withHeaders('Content-Type', 'application/json')
    ->withBody(['key' => 'value'])
    ->withToken('fake-bearer-auth-token')
    ->post('/posts'))
    ->then(fn (ResponseInterface $response) => $data = $response->json())  // Success handler
    ->catch(fn (Throwable $e) => $e->getMessage());                // Error handler

echo $data;

use Fetch\Interfaces\Response as ResponseInterface;

$data = null;

async(fn () => fetch()
    ->baseUri('https://example.com')
    ->withQueryParameters(['page' => 1])
    ->withToken('fake-bearer-auth-token')
    ->get('/resources'))
    ->then(fn (ResponseInterface $response) => $data = $response->json())  // Success handler
    ->catch(fn (Throwable $e) => $e->getMessage());                // Error handler

echo $data;
