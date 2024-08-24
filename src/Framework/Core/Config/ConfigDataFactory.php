<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Core\Config;

use Lamahive\Hive\Framework\Filesystem\Root;

readonly class ConfigDataFactory
{
    public function __construct(private Root $root) {}

    public function create(string $filename): ConfigData
    {
        return new ConfigData($this->root->path . '/config/' . $filename);
    }
}
