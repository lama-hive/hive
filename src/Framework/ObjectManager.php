<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework;

use DI\Container;
use Exception;

class ObjectManager
{
    private static Container $container;

    /**
     * @throws Exception
     */
    public static function getContainer(): Container
    {
        // @todo custom exception
        return static::$container ?? throw new Exception('Container not set yet exception');
    }

    public static function setContainer(Container $container): void
    {
        static::$container = $container;
    }
}
