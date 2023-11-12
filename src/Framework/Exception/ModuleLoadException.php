<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception;

class ModuleLoadException extends FrameworkException
{
    public const MESSAGE = 'Loading module failed: %s.';

    public function __construct(string $loadFilePath, string $message = '')
    {
        parent::__construct(sprintf(static::MESSAGE . $message, $loadFilePath), 0, null);
    }
}
