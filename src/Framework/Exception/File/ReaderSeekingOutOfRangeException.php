<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception\File;

use Lamahive\Hive\Framework\Exception\FrameworkException;
use function sprintf;

class ReaderSeekingOutOfRangeException extends FrameworkException
{
    public const MESSAGE = 'Seek target not reachable. Pointer: %d, Target: %d, EoF: %d';

    public function __construct(int $pointer, int $target, int $eof)
    {
        parent::__construct(sprintf(static::MESSAGE, $pointer, $target, $eof), 0, null);
    }
}
