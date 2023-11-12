<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception\File;

use Lamahive\Hive\Framework\Exception\FrameworkException;

class ReaderNoFileOpenedException extends FrameworkException
{
    public const MESSAGE = 'Reader was not loaded with a file.';
}
