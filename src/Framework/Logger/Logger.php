<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Logger;

use DateTimeZone;
use Monolog\Logger as MonoLogger;

class Logger
{
    private MonoLogger $monoLogger;
    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        $this->monoLogger = new MonoLogger($name, $handlers, $processors, $timezone);
    }

    public function log(): MonoLogger
    {
        return $this->monoLogger;
    }
}
