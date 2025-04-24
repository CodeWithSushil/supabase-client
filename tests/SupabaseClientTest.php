<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Supabase\Client;

#[CoversClass(Client::class)]
class SupabaseClientTest extends TestCase
{
    /**
     * @var object supabase client
     */
    private Client $client;

    #[Test]
    protected function setUp(): void
    {
        $this->client = new Client();
        $this->assertInstanceOf(Client::class, $this->client);
        $this->assertSame(Client::class, get_class($this->client));

    }

    /*
        #[Test]
    public function connect()
    {
        $this->assertSame('supabase', $this->client);
    } */
}
