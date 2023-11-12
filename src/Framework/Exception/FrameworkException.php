<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception;

use Exception;
use Throwable;

class FrameworkException extends Exception
{
    public const MESSAGE = '';

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = !empty(static::MESSAGE) ? $message : static::MESSAGE;
        parent::__construct($message, $code, $previous);
    }
}
