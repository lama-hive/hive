<?php

declare(strict_types=1);

namespace Lamahive\Hive\Tests\Framework\Http;

use Lamahive\Hive\Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testRequest()
    {
        $request = new Request();

        $this->assertTrue(true);
    }
}
