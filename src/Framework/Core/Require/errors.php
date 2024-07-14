<?php

declare(strict_types=1);

use Lamahive\Hive\Framework\Core\Exception\ErrorException;

set_error_handler(function ($severity, $message, $file, $line) {
    /** @noinspection PhpUnhandledExceptionInspection */
    throw new ErrorException($message, 0, $severity, $file, $line);
});


