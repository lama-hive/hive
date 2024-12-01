<?php

declare(strict_types=1);

namespace Lamahive\Hive\Tests\Framework\Core;

use Lamahive\Hive\Framework\Core\DI;
use Lamahive\Hive\Framework\Core\Exception\ObjectBuildException;
use PHPUnit\Framework\TestCase;

class DITest extends TestCase
{
    public const string DITestInstance = '\Lamahive\Hive\Tests\Framework\Core\DITestInstance';

    /**
     * @throws ObjectBuildException
     */
    public function testGet()
    {
        $di = new DI();
        $stdClass = $di->get(self::DITestInstance);

        $this->assertInstanceOf(self::DITestInstance, $stdClass);
    }

    /**
     * @throws ObjectBuildException
     */
    public function testRegister()
    {
        $di = new DI();
        $instance = new DITestInstance();

        $di->register(self::DITestInstance, $instance);
        $this->assertSame($instance, $di->get(self::DITestInstance));
    }

    public function testGetNonExistentClass()
    {
        $di = new DI();
        $this->expectException(ObjectBuildException::class);
        $di->get('\Lamahive\Hive\Tests\Framework\Core\NonExistentClass');
    }
}
