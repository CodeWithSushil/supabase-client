<?php declare(strict_types=1);

namespace Supabase;

class Supabase
{
    private static ?self $instance = null;
    private SupabaseClient $client;

    private function __construct()
    {
        $this->client = new SupabaseClient('YOUR_SUPABASE_URL', 'YOUR_SUPABASE_KEY');
    }

    public static function client(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect(): QueryBuilder
    {
        return new QueryBuilder($this->client);
    }

    public function beginTransaction(): void
    {
        $this->client->rpc('begin_transaction', []);
    }

    public function commit(): void
    {
        $this->client->rpc('commit_transaction', []);
    }

    public function rollback(): void
    {
        $this->client->rpc('rollback_transaction', []);
    }
}
