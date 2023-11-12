<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception\File;

class FileOpenException extends FileException
{
    public const MESSAGE = 'File %s opening failed.';
}
