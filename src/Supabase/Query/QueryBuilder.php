<?php

declare(strict_types=1);

namespace Supabase\Client\Query;

use Supabase\Client\Http\Request;
use Supabase\Client\Http\Response;

class QueryBuilder
{
    protected array $query = [];

    protected array $headers = [];

    protected array|string|null $body = null;

    public function __construct(
        protected Request $request,
        protected string $url,
        protected string $key,
        protected string $table
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Selection
    |--------------------------------------------------------------------------
    */

    public function select(string $columns = '*'): static
    {
        $this->query['select'] = $columns;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public function eq(string $column, mixed $value): static
    {
        return $this->filter($column, 'eq', $value);
    }

    public function neq(string $column, mixed $value): static
    {
        return $this->filter($column, 'neq', $value);
    }

    public function gt(string $column, mixed $value): static
    {
        return $this->filter($column, 'gt', $value);
    }

    public function gte(string $column, mixed $value): static
    {
        return $this->filter($column, 'gte', $value);
    }

    public function lt(string $column, mixed $value): static
    {
        return $this->filter($column, 'lt', $value);
    }

    public function lte(string $column, mixed $value): static
    {
        return $this->filter($column, 'lte', $value);
    }

    public function like(string $column, string $value): static
    {
        return $this->filter($column, 'like', $value);
    }

    public function ilike(string $column, string $value): static
    {
        return $this->filter($column, 'ilike', $value);
    }

    public function in(string $column, array $values): static
    {
        $this->query[$column] = 'in.(' . implode(',', $values) . ')';

        return $this;
    }

    public function is(string $column, string $value): static
    {
        return $this->filter($column, 'is', $value);
    }

    protected function filter(
        string $column,
        string $operator,
        mixed $value
    ): static {
        $this->query[$column] = "{$operator}.{$value}";

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    public function limit(int $limit): static
    {
        $this->query['limit'] = $limit;

        return $this;
    }

    public function offset(int $offset): static
    {
        $this->query['offset'] = $offset;

        return $this;
    }

    public function range(int $from, int $to): static
    {
        $this->headers['Range'] = "{$from}-{$to}";

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Ordering
    |--------------------------------------------------------------------------
    */

    public function order(
        string $column,
        string $direction = 'asc'
    ): static {
        $this->query['order'] =
            "{$column}.{$direction}";

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Mutations
    |--------------------------------------------------------------------------
    */

    public function insert(array $data): Response
    {
        $this->body = $data;

        return $this->send('POST');
    }

    public function update(array $data): Response
    {
        $this->body = $data;

        return $this->send('PATCH');
    }

    public function delete(): Response
    {
        return $this->send('DELETE');
    }

    /*
    |--------------------------------------------------------------------------
    | Execute
    |--------------------------------------------------------------------------
    */

    public function get(): Response
    {
        return $this->send('GET');
    }

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    */

    public function header(
        string $key,
        string $value
    ): static {
        $this->headers[$key] = $value;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Internal
    |--------------------------------------------------------------------------
    */

    protected function send(
        string $method
    ): Response {
        $query = http_build_query(
            $this->query
        );

        $url = sprintf(
            '%s/rest/v1/%s?%s',
            $this->url,
            $this->table,
            $query
        );

        return $this->request->send(
            method: $method,
            url: $url,
            headers: array_merge([
                'apikey'        => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ], $this->headers),
            body: $this->body
        );
    }
}
