<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

readonly class Root
{
    public string $path;

    public function __construct()
    {
        $this->path = __DIR__ . '/../../../fs/';
    }
}
