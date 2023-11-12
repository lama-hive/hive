<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Exception\File;

class FileNotFoundException extends FileException
{
    public const MESSAGE = "Given file %s was not found.";
}
