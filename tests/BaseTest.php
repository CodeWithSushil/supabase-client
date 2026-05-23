<?php

declare(strict_types=1);

namespace Supabase\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Calculator::class)]
class BaseTest extends TestCase
{
    #[Test]
    public function two_number_same()
    {
        $this->assertSame(4, 4);
    }
}
