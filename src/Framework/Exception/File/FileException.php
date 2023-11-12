<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception\File;

use Lamahive\Hive\Framework\Exception\FrameworkException;
use function sprintf;

class FileException extends FrameworkException
{
    public const MESSAGE = '';

    public function __construct(string $fileName)
    {
        parent::__construct(sprintf(static::MESSAGE, $fileName), 0, null);
    }
}
