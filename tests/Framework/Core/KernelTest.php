<?php

declare(strict_types=1);

namespace Lamahive\Hive\Tests\Framework\Core;

use Lamahive\Hive\Framework\Core\Exception\BootException;
use Lamahive\Hive\Framework\Core\Kernel;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    /**
     * @throws BootException
     */
    public function testBoot()
    {
        $kernel = new Kernel();
        $kernel->boot();

        $this->assertTrue(true);
    }
}
