<?php

declare(strict_types=1);

namespace Lamahive\Hive\Tests\Framework\Utils;

use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;
use Lamahive\Hive\Framework\Core\Exception\CoreException;
use Lamahive\Hive\Framework\Utils\Clock;
use PHPUnit\Framework\TestCase;

class ClockTest extends TestCase
{
    /**
     * @throws CoreException
     * @throws DateMalformedStringException
     */
    public function testGetUtcDateTime()
    {
        $clock = new Clock();
        $utcDateTime = $clock->getUtcDateTime();

        $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

        $this->assertInstanceOf(DateTimeImmutable::class, $utcDateTime);
        $this->assertEquals('UTC', $utcDateTime->getTimezone()->getName());
        $this->assertEquals($now->format('Y-m-d H:i:s'), $utcDateTime->format('Y-m-d H:i:s'));
    }
}
